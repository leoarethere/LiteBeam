<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        $this->category = NewsCategory::factory()->create();
    }

    public function test_admin_can_view_news_list(): void
    {
        News::factory()->count(3)->create(['news_category_id' => $this->category->id]);
        $response = $this->actingAs($this->admin)->get(route('dashboard.news.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_news(): void
    {
        $response = $this->actingAs($this->admin)->post(route('dashboard.news.store'), [
            'title' => 'Breaking News',
            'slug' => 'breaking-news',
            'news_category_id' => $this->category->id,
            'body' => 'This is a breaking news story.',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('dashboard.news.index'));
        $this->assertDatabaseHas('news', [
            'title' => 'Breaking News',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_update_news(): void
    {
        $news = News::factory()->create(['news_category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->put(route('dashboard.news.update', $news), [
            'title' => 'Updated News',
            'slug' => 'updated-news',
            'news_category_id' => $this->category->id,
            'body' => 'Updated content.',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('dashboard.news.index'));
        $this->assertDatabaseHas('news', ['id' => $news->id, 'title' => 'Updated News']);
    }

    public function test_admin_can_delete_news(): void
    {
        $news = News::factory()->create(['news_category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->delete(route('dashboard.news.destroy', $news));
        $response->assertRedirect(route('dashboard.news.index'));
        $this->assertDatabaseHas('news', ['id' => $news->id, 'deleted_at' => $news->fresh()->deleted_at]);
    }

    public function test_frontend_news_index_is_public(): void
    {
        News::factory()->count(3)->create(['news_category_id' => $this->category->id]);

        $response = $this->get(route('news.index'));
        $response->assertStatus(200);
        $response->assertViewHas('news');
    }

    public function test_frontend_shows_only_published_news(): void
    {
        News::factory()->create(['news_category_id' => $this->category->id, 'status' => 'published']);
        News::factory()->draft()->create(['news_category_id' => $this->category->id]);

        $response = $this->get(route('news.index'));
        $newsItems = $response->viewData('news');
        $this->assertEquals(1, $newsItems->total());
    }

    public function test_frontend_news_detail_increments_views(): void
    {
        $news = News::factory()->create(['news_category_id' => $this->category->id, 'views' => 0]);

        $this->get(route('news.show', $news));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'views' => 1,
        ]);
    }
}

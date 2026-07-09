<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        $this->category = Category::factory()->create();
    }

    public function test_admin_can_view_posts_list(): void
    {
        Post::factory()->count(3)->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->get(route('dashboard.posts.index'));
        $response->assertStatus(200);
        $response->assertViewHas('posts');
    }

    public function test_admin_can_view_create_post_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('dashboard.posts.create'));
        $response->assertStatus(200);
        $response->assertViewHas('categories');
    }

    public function test_admin_can_create_a_published_post(): void
    {
        $response = $this->actingAs($this->admin)->post(route('dashboard.posts.store'), [
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'category_id' => $this->category->id,
            'body' => 'This is the body content of the test post.',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('dashboard.posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'status' => 'published',
            'user_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_create_a_draft_post(): void
    {
        $response = $this->actingAs($this->admin)->post(route('dashboard.posts.store'), [
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'category_id' => $this->category->id,
            'body' => 'Draft body content.',
            'action' => 'draft',
        ]);

        $response->assertRedirect(route('dashboard.posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Draft Post',
            'status' => 'draft',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post(route('dashboard.posts.store'), []);
        $response->assertSessionHasErrors(['title', 'slug', 'category_id', 'body', 'action']);
    }

    public function test_admin_can_view_edit_post_form(): void
    {
        $post = Post::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->get(route('dashboard.posts.edit', $post));
        $response->assertStatus(200);
        $response->assertViewHas('post');
        $response->assertViewHas('categories');
    }

    public function test_admin_can_update_a_post(): void
    {
        $post = Post::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->put(route('dashboard.posts.update', $post), [
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'category_id' => $this->category->id,
            'body' => 'Updated body content.',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('dashboard.posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_update_validates_unique_slug(): void
    {
        $post1 = Post::factory()->create(['category_id' => $this->category->id]);
        $post2 = Post::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->put(route('dashboard.posts.update', $post2), [
            'title' => $post2->title,
            'slug' => $post1->slug,
            'category_id' => $this->category->id,
            'body' => 'Some body content.',
            'action' => 'publish',
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_admin_can_delete_a_post(): void
    {
        $post = Post::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->delete(route('dashboard.posts.destroy', $post));

        $response->assertRedirect(route('dashboard.posts.index'));
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => $post->fresh()->deleted_at]);
    }

    public function test_guest_cannot_access_post_management(): void
    {
        $response = $this->get(route('dashboard.posts.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_frontend_posts_list_is_public(): void
    {
        Post::factory()->count(5)->create(['category_id' => $this->category->id]);

        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
        $response->assertViewHas('posts');
    }

    public function test_frontend_shows_only_published_posts(): void
    {
        Post::factory()->create(['category_id' => $this->category->id, 'status' => 'published']);
        Post::factory()->draft()->create(['category_id' => $this->category->id]);

        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);

        $posts = $response->viewData('posts');
        $this->assertEquals(1, $posts->total());
    }

    public function test_frontend_post_detail_increments_views(): void
    {
        $post = Post::factory()->create(['category_id' => $this->category->id, 'views' => 0]);

        $this->get(route('posts.show', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'views' => 1,
        ]);
    }
}

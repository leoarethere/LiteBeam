<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'users' => User::count(),
            'recent_activities' => $this->getRecentActivities()
        ];

        return view('backend.dashboard', compact('stats'));
    }

    private function getRecentActivities()
    {
        // Combine and sort recent activities
        $activities = collect();
        
        // Add recent posts
        Post::latest()->take(3)->get()->each(function($post) use ($activities) {
            $activities->push([
                'user' => $post->author,
                'action' => 'menerbitkan post baru',
                'time' => $post->created_at
            ]);
        });

        return $activities->sortByDesc('time')->take(5);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts      = Post::count();
        $publishedPosts  = Post::where('is_published', 1)->count();
        $draftPosts      = Post::where('is_published', 0)->count();
        $totalCategories = Category::count();
        $recentPosts     = Post::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalCategories',
            'recentPosts'
        ));
    }
}
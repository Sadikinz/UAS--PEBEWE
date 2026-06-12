<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'user')
            ->where('is_published', 1)
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::all();

        return view('pages.home', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with('category', 'user')
            ->where('slug', $slug)
            ->where('is_published', 1)
            ->firstOrFail();

        $related = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', 1)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.detail', compact('post', 'related'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with('category', 'user')
            ->where('category_id', $category->id)
            ->where('is_published', 1)
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::all();

        return view('pages.category', compact('posts', 'category', 'categories'));
    }
}
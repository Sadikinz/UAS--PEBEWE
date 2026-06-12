<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'user')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $posts = Post::with('category', 'user')
            ->where(function($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                      ->orWhere('author_name', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['q' => $keyword]);

        return view('admin.posts.index', compact('posts', 'keyword'));
    }

    public function pending()
    {
        $posts = Post::with('category', 'user')
            ->where('is_published', 0)
            ->whereNotNull('user_id')
            ->latest()
            ->paginate(10);
        return view('admin.posts.pending', compact('posts'));
    }

    public function approve(Post $post)
    {
        $post->update([
            'is_published' => 1,
            'published_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Post berhasil disetujui.');
    }

    public function reject(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post berhasil ditolak dan dihapus.');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
            'author_name' => 'required|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id'      => auth()->id(),
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'image'        => $imagePath,
            'author_name'  => $request->author_name,
            'is_published' => $request->has('is_published') ? 1 : 0,
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
            'author_name' => 'required|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image && !str_starts_with($post->image, 'http')) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'image'        => $imagePath,
            'author_name'  => $request->author_name,
            'is_published' => $request->has('is_published') ? 1 : 0,
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diupdate.');
    }

    public function destroy(Post $post)
    {
        if ($post->image && !str_starts_with($post->image, 'http')) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
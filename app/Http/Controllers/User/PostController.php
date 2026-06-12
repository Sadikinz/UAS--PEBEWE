<?php

namespace App\Http\Controllers\User;

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
        $posts = Post::where('user_id', auth()->id())->with('category')->latest()->paginate(10);
        return view('user.dashboard', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
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
            'author_name'  => auth()->user()->name,
            'is_published' => 0,
            'published_at' => null,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Post berhasil dikirim, menunggu persetujuan admin.');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak.');
        }
        $categories = Category::all();
        return view('user.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
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
            'is_published' => 0,
            'published_at' => null,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Post diupdate, menunggu persetujuan admin kembali.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak.');
        }

        if ($post->image && !str_starts_with($post->image, 'http')) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('user.dashboard')->with('success', 'Post berhasil dihapus.');
    }
}
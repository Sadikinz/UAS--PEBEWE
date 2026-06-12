@extends('layouts.app')

@section('title', $category->name . ' — Craftfolio')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/page-category.css') }}">
@endsection

@section('content')
<div class="cat-hero">
    <p class="cat-label">Kategori</p>
    <h1 class="cat-title">{{ $category->name }}</h1>
</div>

<div class="container section">
    @if($posts->count())
        <div class="grid">
            @foreach($posts as $post)
                <div class="card">
                    @if($post->image)
                        <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @else
                        <div class="card-no-img">✦</div>
                    @endif
                    <div class="card-body">
                        <p class="card-category">{{ $post->category->name }}</p>
                        <a href="{{ route('post.show', $post->slug) }}">
                            <p class="card-title">{{ $post->title }}</p>
                        </a>
                        <div class="card-meta">
                            <span>{{ $post->author_name }}</span>
                            <span>{{ $post->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $posts->links('vendor.pagination.custom') }}
        </div>
    @else
        <p style="color:#555; font-size:15px; padding: 40px 0;">Belum ada artikel di kategori ini.</p>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', $post->title . ' — Craftfolio')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/page-detail.css') }}">
@endsection

@section('content')
<div class="post-hero">
    <div class="post-hero-inner">
        <p class="post-category">{{ $post->category->name }}</p>
        <h1 class="post-title">{{ $post->title }}</h1>
        <div class="post-meta">
            <span>{{ $post->author_name }}</span>
            <span>{{ $post->published_at->format('d M Y') }}</span>
        </div>
    </div>
</div>

@if($post->image)
    <div class="post-image">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
    </div>
@endif

<div class="post-content">
    {!! nl2br(e($post->content)) !!}
</div>

@if($related->count())
    <div class="related">
        <div class="container">
            <p class="section-title">Related Posts</p>
            <h2 class="section-heading">Artikel Terkait</h2>
            <div class="related-grid">
                @foreach($related as $item)
                    <div class="related-card">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        @endif
                        <div class="related-card-body">
                            <p class="related-card-cat">{{ $item->category->name }}</p>
                            <a href="{{ route('post.show', $item->slug) }}">
                                <p class="related-card-title">{{ $item->title }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection

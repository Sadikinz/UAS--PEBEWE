@extends('layouts.app')

@section('title', 'Craftfolio — Blog untuk Graphic Designer')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/page-home.css') }}">
@endsection

@section('content')

<div class="hero">
    <div class="hero-inner">
        <div class="hero-left">
            <span class="hero-tag">✦ Blog untuk Graphic Designer</span>
            <h1>Design Stories<br>Worth <span>Reading</span></h1>
            <p class="hero-desc">Inspirasi, tutorial, dan insight untuk para graphic designer profesional. Temukan karya terbaik dari komunitas desainer Indonesia.</p>
            <div class="hero-stats">
                <div>
                    <p class="hero-stat-num">{{ \App\Models\Post::where('is_published',1)->count() }}+</p>
                    <p class="hero-stat-label">Artikel</p>
                </div>
                <div>
                    <p class="hero-stat-num">{{ \App\Models\Category::count() }}</p>
                    <p class="hero-stat-label">Kategori</p>
                </div>
                <div>
                    <p class="hero-stat-num">{{ \App\Models\User::count() }}+</p>
                    <p class="hero-stat-label">Penulis</p>
                </div>
            </div>
        </div>
        <div class="hero-right">
            @foreach(\App\Models\Post::with('category')->where('is_published',1)->latest()->take(5)->get() as $hp)
                <a href="{{ route('post.show', $hp->slug) }}" class="hero-card">
                    @if($hp->image_url)
                        <img class="hero-card-img" src="{{ $hp->image_url }}" alt="{{ $hp->title }}">
                    @else
                        <div class="hero-card-no-img">✦</div>
                    @endif
                    <div class="hero-card-body">
                        <p class="hero-card-cat">{{ $hp->category->name }}</p>
                        <p class="hero-card-title">{{ $hp->title }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="container section">
    <p class="section-label">Featured</p>
    <h2 class="section-heading">Pilihan Editor</h2>

    @if($posts->count())
        <div class="featured-grid">
            @php $featured = $posts->first(); $sideItems = $posts->skip(1)->take(3); @endphp

            <a href="{{ route('post.show', $featured->slug) }}" class="featured-main">
                @if($featured->image_url)
                    <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}">
                @else
                    <div class="featured-no-img">✦</div>
                @endif
                <div class="card-body">
                    <p class="card-category">{{ $featured->category->name }}</p>
                    <span class="card-title">{{ $featured->title }}</span>
                    <p class="card-excerpt">{{ Str::limit($featured->content, 120) }}</p>
                    <div class="card-meta">
                        <span>{{ $featured->author_name }}</span>
                        <span>{{ $featured->published_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>

            <div class="side-list">
                @foreach($sideItems as $side)
                    <a href="{{ route('post.show', $side->slug) }}" class="side-card">
                        @if($side->image_url)
                            <img class="side-card-img" src="{{ $side->image_url }}" alt="{{ $side->title }}">
                        @else
                            <div class="side-card-no-img">✦</div>
                        @endif
                        <div class="side-card-body">
                            <p class="side-card-cat">{{ $side->category->name }}</p>
                            <span class="side-card-title">{{ $side->title }}</span>
                            <p class="side-card-meta">{{ $side->author_name }} · {{ $side->published_at->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<hr class="divider-section">

<div class="categories-strip">
    <div class="container">
        <p class="section-label" style="color:#555;">Jelajahi</p>
        <h2 class="section-heading">Kategori</h2>
        <div class="cat-grid">
            @foreach(\App\Models\Category::withCount(['posts' => function($q){ $q->where('is_published',1); }])->get() as $cat)
                <a href="{{ route('post.category', $cat->slug) }}" class="cat-pill">
                    <span class="cat-pill-dot"></span>
                    <span class="cat-pill-name">{{ $cat->name }}</span>
                    <span class="cat-pill-count">{{ $cat->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="container section">
    <p class="section-label">Semua Artikel</p>
    <h2 class="section-heading">Terbaru</h2>

    @if($posts->count())
        <div class="all-posts-grid">
            @foreach($posts as $post)
                <div class="post-card">
                    @if($post->image_url)
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                    @else
                        <div class="post-card-no-img">✦</div>
                    @endif
                    <div class="post-card-body">
                        <p class="post-card-cat">{{ $post->category->name }}</p>
                        <a href="{{ route('post.show', $post->slug) }}" class="post-card-title">{{ $post->title }}</a>
                        <div class="post-card-meta">
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
        <p style="color:#555; font-size:15px;">Belum ada artikel.</p>
    @endif
</div>

@endsection

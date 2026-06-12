@extends('layouts.admin')

@section('title', 'Dashboard — Craftfolio')
@section('page-title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-table.css') }}">
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="stats">
    <div class="stat-card accent">
        <p class="stat-label">Total Posts</p>
        <p class="stat-value">{{ $totalPosts }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Published</p>
        <p class="stat-value">{{ $publishedPosts }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Draft</p>
        <p class="stat-value">{{ $draftPosts }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Categories</p>
        <p class="stat-value">{{ $totalCategories }}</p>
    </div>
</div>

<h2 class="section-heading">Post Terbaru</h2>
<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Author</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recentPosts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->author_name }}</td>
                <td>
                    @if($post->is_published)
                        <span class="badge badge-published">Published</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

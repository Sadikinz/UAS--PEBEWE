@extends('layouts.user')

@section('title', 'Edit Post — Craftfolio')
@section('page-title', 'Edit Post')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="info-box">
    Setelah diedit, post akan kembali menunggu persetujuan admin.
</div>

<div class="form-card">
    <form method="POST" action="{{ route('user.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Konten</label>
            <textarea name="content" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="image" accept="image/*">
            @if($post->image)
                <div class="current-img">
                    <img src="{{ $post->image_url }}" alt="Current image">
                    <span>Gambar saat ini. Upload baru untuk mengganti.</span>
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update & Kirim Review</button>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

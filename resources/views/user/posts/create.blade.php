@extends('layouts.user')

@section('title', 'Tulis Post — Craftfolio')
@section('page-title', 'Tulis Post Baru')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="info-box">
    Post kamu akan ditinjau oleh admin sebelum ditampilkan di website.
</div>

<div class="form-card">
    <form method="POST" action="{{ route('user.posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Author</label>
            <input type="text" value="{{ auth()->user()->name }}" disabled style="background:#F5F4F0; color:#888;">
        </div>

        <div class="form-group">
            <label>Konten</label>
            <textarea name="content" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar (opsional)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kirim untuk Review</button>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

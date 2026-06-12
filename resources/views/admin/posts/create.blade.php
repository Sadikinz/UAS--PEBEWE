@extends('layouts.admin')

@section('title', 'Tambah Post — Craftfolio')
@section('page-title', 'Tambah Post')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="form-card">
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
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
            <input type="text" name="author_name" value="{{ old('author_name') }}" required>
        </div>

        <div class="form-group">
            <label>Konten</label>
            <textarea name="content" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <div class="checkbox-row">
                <input type="checkbox" name="is_published" id="is_published" value="1"
                       {{ old('is_published') ? 'checked' : '' }}>
                <label for="is_published" style="margin-bottom:0; text-transform:none; font-weight:400;">
                    Publish sekarang
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Post</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

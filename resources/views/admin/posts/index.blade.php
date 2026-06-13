@extends('layouts.admin')

@section('title', 'Posts — Craftfolio')
@section('page-title', 'Posts')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-table.css') }}">
@endsection

@section('content')
<div class="toolbar">
    <form action="{{ route('admin.posts.search') }}" method="GET" class="search-form">
        <input type="text" name="q" placeholder="Cari judul atau author..." value="{{ $keyword ?? '' }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ Tambah Post</a>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Author</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $i => $post)
            <tr>
                <td>{{ $posts->firstItem() + $i }}</td>
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
                <td>{{ $post->created_at->format('d M Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}"
                              onsubmit="return confirm('Yakin hapus post ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#555; padding: 32px;">Belum ada post.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $posts->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection

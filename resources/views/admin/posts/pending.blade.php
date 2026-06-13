@extends('layouts.admin')

@section('title', 'Pending Posts — Craftfolio')
@section('page-title', 'Post Menunggu Persetujuan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-table.css') }}">
@endsection

@section('content')
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Judul & Konten</th>
            <th>Kategori</th>
            <th>Dikirim oleh</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $i => $post)
            <tr>
                <td>{{ $posts->firstItem() + $i }}</td>
                <td>
                    <div style="font-weight:600;">{{ $post->title }}</div>
                    <div class="excerpt">{{ Str::limit($post->content, 80) }}</div>
                </td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->user->name ?? $post->author_name }}</td>
                <td>{{ $post->created_at->format('d M Y') }}</td>
                <td>
                    <div class="actions">
                        <form method="POST" action="{{ route('admin.posts.approve', $post->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-approve">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('admin.posts.reject', $post->id) }}"
                              onsubmit="return confirm('Tolak dan hapus post ini?')">
                            @csrf
                            <button type="submit" class="btn btn-reject">Tolak</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#555; padding:32px;">Tidak ada post yang menunggu persetujuan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $posts->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection

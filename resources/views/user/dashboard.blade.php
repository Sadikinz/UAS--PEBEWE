@extends('layouts.user')

@section('title', 'Dashboard — Craftfolio')
@section('page-title', 'Dashboard Saya')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-table.css') }}">
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="toolbar">
    <p class="page-heading">Post Saya</p>
    <a href="{{ route('user.posts.create') }}" class="btn btn-primary">+ Tulis Post Baru</a>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Kategori</th>
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
                <td>
                    @if($post->is_published)
                        <span class="badge badge-published">Published</span>
                    @else
                        <span class="badge badge-pending">Menunggu Acc</span>
                    @endif
                </td>
                <td>{{ $post->created_at->format('d M Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('user.posts.edit', $post->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('user.posts.destroy', $post->id) }}"
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
                <td colspan="6" style="text-align:center; color:#555; padding:32px;">Belum ada post. Mulai tulis sekarang!</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $posts->links() }}
</div>
@endsection

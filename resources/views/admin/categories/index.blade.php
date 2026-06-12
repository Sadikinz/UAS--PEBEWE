@extends('layouts.admin')

@section('title', 'Categories — Craftfolio')
@section('page-title', 'Categories')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shared-table.css') }}">
<link rel="stylesheet" href="{{ asset('css/shared-form.css') }}">
@endsection

@section('content')
<div class="layout">
    <div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Posts</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <span id="name-{{ $cat->id }}">{{ $cat->name }}</span>
                            <form method="POST" action="{{ route('admin.categories.update', $cat->id) }}"
                                  class="edit-form" id="edit-form-{{ $cat->id }}">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $cat->name }}">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary"
                                        onclick="toggleEdit({{ $cat->id }})">Batal</button>
                            </form>
                        </td>
                        <td>{{ $cat->slug }}</td>
                        <td>{{ $cat->posts_count }}</td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-secondary"
                                        onclick="toggleEdit({{ $cat->id }})">Edit</button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}"
                                      onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#555; padding:32px;">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-card">
        <h3>Tambah Kategori</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <button type="submit" class="btn-full">Tambah</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleEdit(id) {
    const nameEl = document.getElementById('name-' + id);
    const formEl = document.getElementById('edit-form-' + id);
    nameEl.style.display = nameEl.style.display === 'none' ? '' : 'none';
    formEl.classList.toggle('active');
}
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Kelola Buku</h4>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="GET" action="{{ route('buku.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" value="{{ $search }}" class="form-control"
               placeholder="Cari judul atau penulis...">
        <button class="btn btn-outline-primary">Cari</button>
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Sampul</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buku as $item)
                <tr>
                    <td>{{ $buku->firstItem() + $loop->index }}</td>
                    <td>
                        @if($item->cover)
                            <img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->judul }}"
                                 style="width: 50px; height: 70px; object-fit: cover;" class="rounded">
                        @else
                            <span class="text-muted small">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ $item->tahun_terbit }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Data buku tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $buku->links() }}
</div>
@endsection
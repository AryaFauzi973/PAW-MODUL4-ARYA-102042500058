@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="text-center mb-4">
        <h2 class="fw-bold">Katalog Koleksi Buku</h2>
        <p class="text-muted">Temukan dan pinjam buku referensi perkuliahan terbaikmu</p>
    </div>

    {{-- Formulir pencarian terpadu --}}
    <form method="GET" action="{{ route('home') }}" class="row g-2 mb-4 justify-content-center">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ $search }}" class="form-control"
                   placeholder="Cari judul, penulis...">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ $status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="habis" {{ $status === 'habis' ? 'selected' : '' }}>Stok Habis</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                <option value="judul" {{ $sort === 'judul' ? 'selected' : '' }}>Judul (A-Z)</option>
                <option value="tahun" {{ $sort === 'tahun' ? 'selected' : '' }}>Tahun Terbit</option>
                <option value="stok" {{ $sort === 'stok' ? 'selected' : '' }}>Stok Terbanyak</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    {{-- Grid kartu buku --}}
    <div class="row">
        @forelse($buku as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($item->cover)
                        <img src="{{ asset('storage/' . $item->cover) }}" class="card-img-top"
                             style="height: 240px; object-fit: cover;" alt="{{ $item->judul }}">
                    @else
                        <div class="text-center py-5 bg-light text-muted"
                             style="height: 240px;">Tidak Ada Sampul</div>
                    @endif

                    <div class="card-body">
                        <h6>{{ $item->judul }}</h6>
                        <p class="text-muted small">{{ $item->penulis }}</p>
                        <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->stok > 0 ? 'Tersedia (' . $item->stok . ')' : 'Stok Habis' }}
                        </span>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('buku.publik.show', $item->id) }}"
                           class="btn btn-outline-primary btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Buku tidak ditemukan.</p>
        @endforelse
    </div>

    {{ $buku->links() }}
</div>
@endsection
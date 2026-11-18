@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary mb-3">← Kembali ke Katalog</a>

    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-4 p-3 text-center">
                @if($buku->cover)
                    <img src="{{ asset('storage/' . $buku->cover) }}" class="img-fluid rounded"
                         alt="{{ $buku->judul }}">
                @else
                    <div class="bg-light text-muted py-5">Tidak Ada Sampul</div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="fw-bold">{{ $buku->judul }}</h3>
                    <p class="text-muted">{{ $buku->penulis }}</p>
                    <hr>
                    <table class="table table-borderless">
                        <tr><td width="35%">Penerbit</td><td>{{ $buku->penerbit }}</td></tr>
                        <tr><td>Tahun Terbit</td><td>{{ $buku->tahun_terbit }}</td></tr>
                        <tr>
                            <td>Status Ketersediaan</td>
                            <td>
                                <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $buku->stok > 0 ? 'Tersedia (' . $buku->stok . ' eksemplar)' : 'Stok Habis' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    @guest
                        <div class="alert alert-info">
                            Ingin meminjam buku ini? Silakan <a href="{{ route('login') }}">Login</a>
                            terlebih dahulu atau temui petugas perpustakaan.
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
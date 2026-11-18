@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <h4 class="fw-bold">Tambah Buku Baru</h4>

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Buku *</label>
            <input type="text" name="judul" value="{{ old('judul') }}"
                   class="form-control @error('judul') is-invalid @enderror"
                   placeholder="Contoh: Pemrograman Web dengan Laravel">
            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Penulis *</label>
                <input type="text" name="penulis" value="{{ old('penulis') }}"
                       class="form-control @error('penulis') is-invalid @enderror">
                @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Penerbit *</label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                       class="form-control @error('penerbit') is-invalid @enderror">
                @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tahun Terbit *</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}"
                       class="form-control @error('tahun_terbit') is-invalid @enderror">
                @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Jumlah Stok *</label>
                <input type="number" name="stok" value="{{ old('stok', 1) }}"
                       class="form-control @error('stok') is-invalid @enderror">
                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label fw-semibold">Sampul Buku (Opsional)</label>
            <input type="file" class="form-control @error('cover') is-invalid @enderror"
                   id="cover" name="cover" accept="image/*" onchange="previewImage(event)">
            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal: 2 MB.</small>
            @error('cover') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

            <div class="mt-2">
                <img id="imagePreview" src="#" alt="Pratinjau Sampul"
                     class="img-thumbnail d-none" style="max-height: 160px;">
            </div>
        </div>

        <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Buku</button>
    </form>
</div>

<script>
    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
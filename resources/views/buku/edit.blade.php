@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <h4 class="fw-bold">Edit Buku</h4>

    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Buku *</label>
            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                   class="form-control @error('judul') is-invalid @enderror">
            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Penulis *</label>
                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}"
                       class="form-control @error('penulis') is-invalid @enderror">
                @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Penerbit *</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                       class="form-control @error('penerbit') is-invalid @enderror">
                @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tahun Terbit *</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                       class="form-control @error('tahun_terbit') is-invalid @enderror">
                @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Jumlah Stok *</label>
                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}"
                       class="form-control @error('stok') is-invalid @enderror">
                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Sampul Saat Ini</label><br>
            @if($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}"
                     class="img-thumbnail" style="max-height: 120px;">
            @else
                <span class="text-muted">Belum ada sampul</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label fw-semibold">Ganti Sampul (Opsional)</label>
            <input type="file" class="form-control @error('cover') is-invalid @enderror"
                   id="cover" name="cover" accept="image/*" onchange="previewImage(event)">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah sampul. Format: JPG, JPEG, PNG. Maks 2 MB.</small>
            @error('cover') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

            <div class="mt-2">
                <img id="imagePreview" src="#" alt="Pratinjau Sampul"
                     class="img-thumbnail d-none" style="max-height: 160px;">
            </div>
        </div>

        <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary">Perbarui Buku</button>
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
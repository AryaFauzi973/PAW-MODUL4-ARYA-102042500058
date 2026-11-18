<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $buku = Buku::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        })->latest()->paginate(5)->withQueryString();

        return view('admin.buku.index', compact('buku', 'search'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    // Menyimpan buku baru beserta berkas sampul ke storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:100',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            // TODO 4: validasi berkas 'cover'
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.max'             => 'Judul buku maksimal 100 karakter.',
            'penulis.required'      => 'Penulis buku wajib diisi.',
            'penulis.max'           => 'Penulis buku maksimal 100 karakter.',
            'penerbit.required'     => 'Penerbit buku wajib diisi.',
            'penerbit.max'          => 'Penerbit buku maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'stok.required'         => 'Stok buku wajib diisi.',
            'stok.integer'          => 'Stok buku harus berupa angka.',
            'stok.min'              => 'Stok buku tidak boleh kurang dari 0.',
            'cover.image'           => 'Berkas yang diunggah harus berupa gambar.',
            'cover.mimes'           => 'Format gambar harus JPG, JPEG, atau PNG.',
            'cover.max'             => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // TODO 4: periksa jika ada berkas 'cover' yang diunggah
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil disimpan!');
    }

    public function show(Buku $buku)
    {
        return view('home_show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    // Memperbarui data buku dan mengganti berkas sampul
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:100',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.max'             => 'Judul buku maksimal 100 karakter.',
            'penulis.required'      => 'Penulis buku wajib diisi.',
            'penulis.max'           => 'Penulis buku maksimal 100 karakter.',
            'penerbit.required'     => 'Penerbit buku wajib diisi.',
            'penerbit.max'          => 'Penerbit buku maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'stok.required'         => 'Stok buku wajib diisi.',
            'stok.integer'          => 'Stok buku harus berupa angka.',
            'stok.min'              => 'Stok buku tidak boleh kurang dari 0.',
            'cover.image'           => 'Berkas yang diunggah harus berupa gambar.',
            'cover.mimes'           => 'Format gambar harus JPG, JPEG, atau PNG.',
            'cover.max'             => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // TODO 5: hapus berkas sampul lama jika ada sampul baru yang diunggah
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $validated['cover'] = $request->file('cover')->store('buku', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    // Menghapus data buku beserta berkas fisik sampulnya
    public function destroy(Buku $buku)
    {
        // TODO 6: hapus berkas fisik sampul sebelum data dihapus dari database
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus!');
    }
}
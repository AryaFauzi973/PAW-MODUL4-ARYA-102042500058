<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman depan katalog buku
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');          // tersedia / habis
        $sort   = $request->input('sort', 'terbaru'); // terbaru / judul / tahun / stok

        $buku = Buku::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%");
                });
            })
            ->when($status === 'tersedia', fn ($q) => $q->where('stok', '>', 0))
            ->when($status === 'habis', fn ($q) => $q->where('stok', '<=', 0))
            ->when($sort === 'judul', fn ($q) => $q->orderBy('judul', 'asc'))
            ->when($sort === 'tahun', fn ($q) => $q->orderBy('tahun_terbit', 'desc'))
            ->when($sort === 'stok', fn ($q) => $q->orderBy('stok', 'desc'))
            ->when(!in_array($sort, ['judul', 'tahun', 'stok']), fn ($q) => $q->latest())
            ->paginate(5)
            ->withQueryString();

        return view('home', compact('buku', 'search', 'status', 'sort'));
    }

    // Detail buku untuk publik/mahasiswa
    public function show(Buku $buku)
    {
        return view('home_show', compact('buku'));
    }
}
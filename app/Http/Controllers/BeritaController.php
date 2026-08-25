<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    // Menampilkan daftar seluruh berita
    public function index()
    {
        $pengaturan = DB::table('pengaturan_desa')->where('id', 1)->first();
        // Ambil berita yang statusnya publish, urutkan dari terbaru, paginasi 9 per halaman
        $berita = Berita::where('status', 'publish')->latest()->paginate(9);

        return view('berita.index', compact('berita', 'pengaturan'));
    }

    // Menampilkan detail membaca berita
    public function show($slug)
    {
        $pengaturan = DB::table('pengaturan_desa')->where('id', 1)->first();
        // Cari berita berdasarkan slug
        $berita = Berita::where('slug', $slug)->where('status', 'publish')->firstOrFail();

        // Ambil 5 berita lain secara acak/terbaru untuk di sidebar kanan
        $berita_lain = Berita::where('status', 'publish')
            ->where('id', '!=', $berita->id) // Jangan tampilkan berita yang sedang dibaca
            ->latest()
            ->take(5)
            ->get();

        return view('berita.show', compact('berita', 'berita_lain', 'pengaturan'));
    }
}

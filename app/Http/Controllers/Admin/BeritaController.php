<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('admin')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        $berita = $query->paginate(10)->withQueryString();
        $totalBerita = Berita::count();

        return view('admin.berita', compact('berita', 'totalBerita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'status' => 'required|in:publish,draft',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul).'-'.time();
        $data['admin_id'] = Auth::id(); // Mencatat Admin yang memposting

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'status' => 'required|in:publish,draft',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul).'-'.time();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && Storage::exists('public/'.$berita->gambar)) {
                Storage::delete('public/'.$berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::exists('public/'.$berita->gambar)) {
            Storage::delete('public/'.$berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}

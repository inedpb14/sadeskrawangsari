<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Services\KeluargaService;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluarga::with('anggota:no_kk,nik,nama_lengkap');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('no_kk', 'like', "%{$search}%")
                ->orWhere('nama_kepala_keluarga', 'like', "%{$search}%");
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort == 'nama_az') {
            $query->orderBy('nama_kepala_keluarga', 'asc');
        } elseif ($sort == 'nama_za') {
            $query->orderBy('nama_kepala_keluarga', 'desc');
        } elseif ($sort == 'kk_asc') {
            $query->orderBy('no_kk', 'asc');
        } elseif ($sort == 'kk_desc') {
            $query->orderBy('no_kk', 'desc');
        } else {
            $query->latest();
        }

        $keluarga = $query->paginate(15)->withQueryString();
        $totalKeluarga = Keluarga::count();

        return view('admin.keluarga', compact('keluarga', 'totalKeluarga'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|size:16|unique:keluarga,no_kk',
            'nama_kepala_keluarga' => 'required|string|max:150',
        ]);

        app(KeluargaService::class)->create($validated);

        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $request->validate([
            'nama_kepala_keluarga' => 'required|string|max:150',
        ]);

        app(KeluargaService::class)->update($keluarga, $validated);

        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keluarga = Keluarga::findOrFail($id);
        app(KeluargaService::class)->delete($keluarga);

        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil dihapus!');
    }
}

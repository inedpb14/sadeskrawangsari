<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $nik = Auth::guard('warga')->user()->nik;

        $pengaduan = Pengaduan::where('warga_nik', $nik)->latest()->get();

        return view('warga.pengaduan', compact('pengaduan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'judul' => 'required|max:255',
            'isi_pengaduan' => 'required',
            'lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'warga_nik' => Auth::guard('warga')->user()->nik,
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'isi_pengaduan' => $request->isi_pengaduan,
            'status' => 'Baru',
        ];

        if ($request->hasFile('lampiran')) {
            // Simpan file ke folder storage/app/public/pengaduan
            $path = $request->file('lampiran')->store('pengaduan', 'public');
            $data['lampiran_path'] = $path;
        }

        Pengaduan::create($data);

        return back()->with('success', 'Pengaduan berhasil dikirim!');
    }
}

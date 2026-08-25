<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengaturanDesaController extends Controller
{
    public function index()
    {
        $pengaturan = DB::table('pengaturan_desa')->where('id', 1)->first();

        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Validasi lengkap tanpa ada yang dipotong
        $request->validate([
            'nama_desa' => 'nullable|string|max:150',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'visi_misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'sambutan_kades' => 'nullable|string',
            'nama_kades' => 'nullable|string|max:100',
            'foto_kades' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072', // Maksimal 3MB
        ]);

        $exists = DB::table('pengaturan_desa')->where('id', 1)->first();

        // Mengumpulkan data teks yang akan disimpan
        $data = [
            'nama_desa' => $request->nama_desa ?? 'Desa Krawang Sari', // <-- Tambahkan default di sini            'alamat'         => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'visi_misi' => $request->visi_misi,
            'sejarah' => $request->sejarah,
            'sambutan_kades' => $request->sambutan_kades,
            'nama_kades' => $request->nama_kades,
            'updated_at' => now(),
        ];

        // Proses Upload Foto Kades
        if ($request->hasFile('foto_kades')) {
            // Hapus foto lama jika ada
            if ($exists && $exists->foto_kades) {
                Storage::delete('public/'.$exists->foto_kades);
            }
            // Simpan foto baru dan catat letak file-nya di array $data
            $data['foto_kades'] = $request->file('foto_kades')->store('pengaturan', 'public');
        }

        // Proses Upload Hero Image (Banner)
        if ($request->hasFile('hero_image')) {
            // Hapus banner lama jika ada
            if ($exists && $exists->hero_image) {
                Storage::delete('public/'.$exists->hero_image);
            }
            // Simpan banner baru dan catat letak file-nya di array $data
            $data['hero_image'] = $request->file('hero_image')->store('pengaturan', 'public');
        }

        // Eksekusi penyimpanan ke database
        if ($exists) {
            DB::table('pengaturan_desa')->where('id', 1)->update($data);
        } else {
            $data['id'] = 1;
            $data['created_at'] = now();
            DB::table('pengaturan_desa')->insert($data);
        }

        return redirect()->back()->with('success', 'Pengaturan wajah desa berhasil diperbarui!');
    }
}

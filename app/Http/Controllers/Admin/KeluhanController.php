<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KeluhanController extends Controller
{
    public function index(Request $request)
    {
        // Panggil relasi warga agar bisa menampilkan nama pelapor
        $query = Pengaduan::with('warga')->latest();

        // Fitur Pencarian (Berdasarkan Judul atau Nama Pelapor)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                ->orWhereHas('warga', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                });
        }

        // Fitur Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $keluhan = $query->paginate(10)->withQueryString();

        // Hitung statistik untuk Dashboard Atas
        $stats = [
            'total' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
        ];

        return view('admin.keluhan', compact('keluhan', 'stats'));
    }

    public function update(Request $request, $id)
    {
        $keluhan = Pengaduan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak', // Sesuaikan enum di database Anda
            'tanggapan_admin' => 'nullable|string',
        ]);

        $keluhan->update([
            'status' => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'admin_id' => Auth::id(), // Catat admin siapa yang merespon
        ]);

        return redirect()->route('admin.keluhan.index')->with('success', 'Tanggapan & status keluhan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keluhan = Pengaduan::findOrFail($id);

        // Hapus file lampiran jika ada
        if ($keluhan->lampiran_path && Storage::exists('public/'.$keluhan->lampiran_path)) {
            Storage::delete('public/'.$keluhan->lampiran_path);
        }

        $keluhan->delete();

        return redirect()->route('admin.keluhan.index')->with('success', 'Data keluhan berhasil dihapus permanen!');
    }
}

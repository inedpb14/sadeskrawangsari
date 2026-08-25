<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendudukExport;
use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%")
                    ->orWhere('no_kk', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $warga = $query->latest()->paginate($request->input('per_page', 10));

        $totalWarga = Warga::count();
        $totalKeluarga = Warga::distinct('no_kk')->count();

        $genderStats = Warga::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')->get();

        $statusNikahStats = Warga::select('status_perkawinan', DB::raw('count(*) as total'))
            ->groupBy('status_perkawinan')->get();

        $ageStats = Warga::select(DB::raw("CASE 
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 18 THEN 'Anak-anak'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 60 THEN 'Produktif'
                ELSE 'Lansia' 
            END as kelompok_usia"), DB::raw('count(*) as total'))
            ->groupBy('kelompok_usia')
            ->orderByRaw("FIELD(kelompok_usia, 'Anak-anak', 'Produktif', 'Lansia')")
            ->get();

        return view('admin.penduduk', compact(
            'warga',
            'totalWarga',
            'totalKeluarga',
            'genderStats',
            'statusNikahStats',
            'ageStats'
        ));
    }

    public function exportData(Request $request)
    {
        $columns = $request->input('columns', ['nik', 'nama_lengkap']);
        $filters = $request->only(['search', 'agama', 'status_perkawinan', 'jenis_kelamin']);

        $fileName = 'Data_Penduduk_'.date('YmdHis').'.xlsx';

        return Excel::download(new PendudukExport($columns, $filters), $fileName);
    }

    public function show($nik)
    {
        $warga = Warga::where('nik', $nik)->first();

        if (! $warga) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Hanya kembalikan field yang dibutuhkan (hindari leak user_id, is_active, dll)
        return response()->json([
            'nik' => $warga->nik,
            'nama_lengkap' => $warga->nama_lengkap,
            'no_kk' => $warga->no_kk,
            'tempat_lahir' => $warga->tempat_lahir,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'jenis_kelamin' => $warga->jenis_kelamin,
            'alamat_jalan' => $warga->alamat_jalan,
            'rt_rw' => $warga->rt_rw,
            'kel_desa' => $warga->kel_desa,
            'kecamatan' => $warga->kecamatan,
            'agama' => $warga->agama,
            'status_perkawinan' => $warga->status_perkawinan,
            'pekerjaan' => $warga->pekerjaan,
            'kewarganegaraan' => $warga->kewarganegaraan,
            'no_hp' => $warga->no_hp,
            'foto' => $warga->foto,
            'is_active' => $warga->is_active,
        ]);
    }

    public function destroy($nik)
    {
        $warga = Warga::where('nik', $nik)->first();

        if (! $warga) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // Cek relasi sebelum hapus
        $hasPengajuan = PengajuanSurat::where('warga_nik', $nik)->exists();
        $hasPengaduan = Pengaduan::where('warga_nik', $nik)->exists();
        $hasUser = User::where('id', $warga->user_id)->exists();

        if ($hasPengajuan || $hasPengaduan) {
            return back()->with('error', 'Tidak bisa menghapus: warga ini memiliki riwayat pengajuan surat atau pengaduan.');
        }

        // Hapus user terkait jika ada
        if ($hasUser) {
            User::where('id', $warga->user_id)->delete();
        }

        $warga->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}

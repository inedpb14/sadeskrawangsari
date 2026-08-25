<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileWargaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('warga')->user();

        return view('warga.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('warga')->user();

        $validated = $request->validate([
            'nama_lengkap' => 'required|max:150',
            'no_kk' => 'nullable|digits:16',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_jalan' => 'required|max:255',
            'rt_rw' => 'required|max:10',
            'kel_desa' => 'required|max:100',
            'kecamatan' => 'required|max:100',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|max:100',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'no_hp' => 'nullable|max:15',
            'email' => 'nullable|email|max:150|unique:users,email,'.$user->user_id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $wargaData = $request->only([
            'nama_lengkap', 'no_kk', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'alamat_jalan', 'rt_rw', 'kel_desa',
            'kecamatan', 'agama', 'status_perkawinan', 'pekerjaan',
            'kewarganegaraan', 'no_hp',
        ]);

        // Sinkronisasi email ke tabel users (via relasi user_id)
        if ($request->filled('email') && $user->user_id) {
            $user->user()->update(['email' => $request->email]);
        }

        // Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada DAN bukan file default
            if ($user->foto && $user->foto !== 'foto_profil/nopict.png' && Storage::exists('public/'.$user->foto)) {
                Storage::delete('public/'.$user->foto);
            }

            $fileName = time().'_'.$user->nik.'.'.$request->foto->extension();
            $path = $request->file('foto')->storeAs('foto_profil', $fileName, 'public');
            $wargaData['foto'] = $path;
        }

        $user->update($wargaData);

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}

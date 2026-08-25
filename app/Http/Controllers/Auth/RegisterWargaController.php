<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan Model User di-import
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Import DB untuk Transaction

class RegisterWargaController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-warga');
    }

    public function register(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nik' => 'required|digits:16',
            'email' => 'required|email|unique:users,email', // Ubah validasi unique ke tabel users
            'password' => 'required|min:8|confirmed',
        ], [
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Gunakan DB Transaction agar aman (jika gagal satu, gagal semua)
        try {
            DB::beginTransaction();

            // 2. Buat Akun Login di tabel users
            $user = User::create([
                'name' => $request->nama_lengkap ?? 'Warga Baru',
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 3. Update atau Create data profil di tabel warga
            // Jika NIK sudah ada & punya user_id, HANYA update user_id (jangan timpa data profil)
            // Jika NIK belum ada, create dengan default
            $warga = Warga::where('nik', $request->nik)->first();

            if ($warga && $warga->user_id) {
                // NIK sudah terdaftar ke user lain -> error
                if ($warga->user_id !== $user->id) {
                    throw new \Exception('NIK ini sudah terdaftar untuk akun lain.');
                }
                $warga->update(['user_id' => $user->id]);
            } else {
                // NIK belum ada atau belum punya user_id -> create/update dengan default
                Warga::updateOrCreate(
                    ['nik' => $request->nik],
                    [
                        'user_id' => $user->id,
                        'nama_lengkap' => $request->nama_lengkap ?? 'Warga Baru',
                        'tempat_lahir' => $request->tempat_lahir ?? 'Indonesia',
                        'tanggal_lahir' => $request->tanggal_lahir ?? '1991-01-01',
                        'jenis_kelamin' => $request->jenis_kelamin ?? 'P',
                        'alamat_jalan' => $request->alamat_jalan ?? 'Indonesia',
                        'rt_rw' => $request->rt_rw ?? '01/01',
                        'kel_desa' => $request->kel_desa ?? 'Indonesia',
                        'kecamatan' => $request->kecamatan ?? 'Indonesia',
                        'agama' => $request->agama ?? 'Islam',
                        'status_perkawinan' => $request->status_perkawinan ?? 'Belum Kawin',
                        'pekerjaan' => $request->pekerjaan ?? 'Belum ada pekerjaan',
                    ]
                );
            }

            DB::commit();

            return redirect()->route('login.warga')->with('success', 'Akun berhasil didaftarkan! Silahkan login.');
        } catch (\Exception $e) {
            // Jika ada error (misal database mati), batalkan semua proses
            DB::rollBack();

            // Kembalikan user ke halaman form dengan pesan error
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: '.$e->getMessage()]);
        }
    }
}

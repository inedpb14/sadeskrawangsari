<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\KeluargaController as AdminKeluargaController;
use App\Http\Controllers\Admin\KeluhanController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\PengaturanDesaController;
use App\Http\Controllers\Admin\SuratArsipController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginWargaController;
use App\Http\Controllers\Auth\RegisterWargaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HalamanPublikController;
use App\Http\Controllers\KeluhanPublikController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Penduduk\DashboardWargaController;
use App\Http\Controllers\Penduduk\KeluargaController;
use App\Http\Controllers\Penduduk\PengaduanController;
use App\Http\Controllers\Penduduk\PengajuanSuratController;
use App\Http\Controllers\Penduduk\ProfileWargaController;
use App\Http\Controllers\Penduduk\RiwayatPengajuanController;
use Illuminate\Support\Facades\Route;

// Route Pengunjung
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/suara-warga', [KeluhanPublikController::class, 'index'])->name('keluhan');

// --- MENU PROFIL DESA ---
Route::get('/profil/sejarah', [HalamanPublikController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/profil/visi-misi', [HalamanPublikController::class, 'visiMisi'])->name('profil.visi_misi');
Route::get('/profil/perangkat', [HalamanPublikController::class, 'perangkat'])->name('profil.perangkat');

// --- MENU LAYANAN PENDUDUK ---
Route::get('/layanan/panduan', [HalamanPublikController::class, 'panduan'])->name('layanan.panduan');
Route::get('/layanan/ajukan', [HalamanPublikController::class, 'ajukan'])->name('layanan.ajukan');
Route::get('/layanan/status', [HalamanPublikController::class, 'status'])->name('layanan.status');

// --- MENU STATISTIK ---
Route::get('/statistik', [HalamanPublikController::class, 'statistik'])->name('statistik.index');

// Login Warga
Route::middleware(['guest'])->group(function () {
    Route::get('/login-warga', [LoginWargaController::class, 'showLoginForm'])->name('login.warga');
    Route::post('/login-warga', [LoginWargaController::class, 'login']);

    Route::get('/login-admin', [LoginAdminController::class, 'showLoginForm'])->name('login.admin');
    Route::post('/login-admin', [LoginAdminController::class, 'login']);

    Route::get('/register-warga', [RegisterWargaController::class, 'showRegistrationForm'])->name('register.warga');
    Route::post('/register-warga', [RegisterWargaController::class, 'register']);
});

// Route Warga
Route::middleware(['auth:warga'])->group(function () {
    Route::get('/dashboard-warga', [DashboardWargaController::class, 'index'])->name('dashboard.warga');

    Route::post('/logout-warga', [LoginWargaController::class, 'logout'])->name('logout.warga');

    Route::get('/buat-pengajuan', [PengajuanSuratController::class, 'index'])->name('pengajuan.katalog');
    Route::get('/buat-pengajuan/{jenis}', [PengajuanSuratController::class, 'create'])->name('pengajuan.create');
    Route::post('/buat-pengajuan/store', [PengajuanSuratController::class, 'store'])->name('pengajuan.store');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::post('/pengaduan/kirim', [PengaduanController::class, 'store'])->name('pengaduan.store');

    Route::get('/warga/riwayat-pengajuan', [RiwayatPengajuanController::class, 'index'])->name('riwayat.index');
    Route::get('/warga/pengajuan/cetak/{id}', [PengajuanSuratController::class, 'cetakSurat'])->name('pengajuan.cetak');

    Route::get('/profil-saya', [ProfileWargaController::class, 'index'])->name('profile.warga');
    Route::post('/profil-saya/update', [ProfileWargaController::class, 'update'])->name('profile.update');

    Route::get('/data-keluarga', [KeluargaController::class, 'index'])->name('keluarga.warga');
    Route::post('/data-keluarga/store', [KeluargaController::class, 'storeKeluarga'])->name('keluarga.store');
    Route::post('/data-keluarga/add-anggota', [KeluargaController::class, 'addAnggota'])->name('keluarga.addAnggota');
});

// Route Admin
Route::middleware(['auth', 'role:admin,kades'])->group(function () {
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/surat-masuk', [SuratMasukController::class, 'index'])->name('admin.surat-masuk');
    Route::post('/admin/surat-proses/{id}', [SuratMasukController::class, 'updateStatus'])->name('admin.surat-proses');
    Route::post('/admin/surat-setujui/{id}', [SuratMasukController::class, 'setujuiSurat'])->name('admin.surat-setujui');
    Route::post('/admin/surat-tolak/{id}', [SuratMasukController::class, 'tolakSurat'])->name('admin.surat-tolak');
    Route::get('/admin/surat-detail/{id}', [SuratMasukController::class, 'show'])->name('admin.surat-detail');
    Route::get('/admin/surat-cetak/{id}', [SuratMasukController::class, 'cetakSurat'])->name('admin.surat-cetak');

    Route::get('/admin/surat-arsip', [SuratArsipController::class, 'index'])->name('admin.surat-arsip');

    Route::get('/admin/penduduk', [PendudukController::class, 'index'])->name('admin.penduduk');
    Route::get('/admin/penduduk/export-proses', [PendudukController::class, 'exportData'])->name('admin.penduduk.export');
    Route::get('/admin/penduduk/detail/{nik}', [PendudukController::class, 'show'])->name('admin.penduduk.show');
    Route::delete('/admin/penduduk/{nik}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

    Route::get('/admin/keluarga', [AdminKeluargaController::class, 'index'])->name('admin.keluarga.index');
    Route::post('/admin/keluarga', [AdminKeluargaController::class, 'store'])->name('admin.keluarga.store');
    Route::put('/admin/keluarga/{id}', [AdminKeluargaController::class, 'update'])->name('admin.keluarga.update');
    Route::delete('/admin/keluarga/{id}', [AdminKeluargaController::class, 'destroy'])->name('admin.keluarga.destroy');

    Route::get('/admin/keluhan', [KeluhanController::class, 'index'])->name('admin.keluhan.index');
    Route::put('/admin/keluhan/{id}', [KeluhanController::class, 'update'])->name('admin.keluhan.update');
    Route::delete('/admin/keluhan/{id}', [KeluhanController::class, 'destroy'])->name('admin.keluhan.destroy');

    Route::get('/admin/berita', [AdminBeritaController::class, 'index'])->name('admin.berita.index');
    Route::post('/admin/berita', [AdminBeritaController::class, 'store'])->name('admin.berita.store');
    Route::put('/admin/berita/{id}', [AdminBeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/admin/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('admin.berita.destroy');

    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
    Route::put('/admin/profile/update', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update_self');
    Route::post('/admin/manage', [AdminProfileController::class, 'storeAdmin'])->name('admin.manage.store');
    Route::put('/admin/manage/{id}', [AdminProfileController::class, 'updateAdmin'])->name('admin.manage.update');
    Route::delete('/admin/manage/{id}', [AdminProfileController::class, 'destroyAdmin'])->name('admin.manage.destroy');

    Route::get('/admin/pengaturan', [PengaturanDesaController::class, 'index'])->name('admin.pengaturan');
    Route::post('/admin/pengaturan/update', [PengaturanDesaController::class, 'update'])->name('admin.pengaturan.update');

    Route::post('/logout-admin', [LoginAdminController::class, 'logout'])->name('admin.logout');
});

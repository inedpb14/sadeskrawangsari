<?php
date_default_timezone_set('Asia/Jakarta');

$nama_hari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$nama_bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];

$hari = $nama_hari[date('l')];
$tanggal = date('d');
$bulan = $nama_bulan[(int) date('m')];
$tahun = date('Y');
?>

<div class="sidebar">
    <div class="sidebar-header"
        style="padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <img src="{{ asset('img/mainLogo.png') }}" width="60" style="filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
        <h3 style="margin-top: 15px; font-family: 'Domine'; font-size: 18px; letter-spacing: 1px;">DESA KRAWANG SARI
        </h3>
        <h6 style="opacity: 0.8; font-weight: 400; font-size: 12px;"><?php echo "$hari, $tanggal $bulan $tahun"; ?></h6>
    </div>

    <nav class="sidebar-menu"
        style="padding: 20px 0; display: flex; flex-direction: column; height: calc(100vh - 180px); overflow-y: auto;">
        <small class="menu-label"
            style="display: block; padding: 10px 25px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Navigasi
            Utama</small>

        <a href="{{ route('dashboard.warga') }}"
            class="menu-item {{ request()->routeIs('dashboard.warga') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Layanan
            Persuratan</small>
        <a href="{{ route('pengajuan.katalog') }}"
            class="menu-item {{ request()->routeIs('pengajuan.katalog') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i> Buat Pengajuan
        </a>
        <a href="{{ route('riwayat.index') }}" class="menu-item">
            <i class="fas fa-history"></i> Riwayat & Progres
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Layanan
            Publik</small>
        <a href="{{ route('pengaduan') }}"
            class="menu-item {{ request()->routeIs('pengaduan') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i> Buat Pengajuan
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Data
            Penduduk</small>
        <a href="{{ route('profile.warga') }}"
            class="menu-item {{ request()->routeIs('profile.warga') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Profil Saya
        </a>
        <a href="{{ route('keluarga.warga') }}"
            class="menu-item {{ request()->routeIs('keluarga.warga') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Data Keluarga
        </a>

        <div class="sidebar-footer" style="margin-top: auto; padding: 20px;">
            <form action="{{ route('logout.warga') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-sidebar"
                    style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #e74c3c; color: white; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s;">
                    <i class="fas fa-power-off"></i> Keluar Aplikasi
                </button>
            </form>
        </div>
    </nav>
</div>
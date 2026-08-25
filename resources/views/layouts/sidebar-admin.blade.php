<?php
date_default_timezone_set('Asia/Jakarta');

$nama_hari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
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
    'Desember',
];

$hari = $nama_hari[date('l')];
$tanggal = date('d');
$bulan = $nama_bulan[(int) date('m')];
$tahun = date('Y');
?>

<style>
    /* 1. Pengaturan Scroll pada Sidebar Utama */
    .sidebar {
        width: var(--sidebar-width);
        background-color: var(--color-1);
        height: 100vh;
        /* Paksa tinggi sidebar seukuran layar browser */
        color: white;
        position: fixed;
        left: 0;
        top: 0;
        transition: transform var(--transition-speed) ease;
        z-index: 1050;

        /* Aktifkan Scroll Y */
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    /* 2. Percantik Tampilan Scrollbar (Webkit) */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Styling Menu Item */
    .menu-item {
        padding: 12px 25px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: 0.3s;
        flex-shrink: 0;
        /* Mencegah menu gepeng saat konten banyak */
    }

    .menu-item:hover,
    .menu-item.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left: 4px solid #fff;
    }

    .badge-count {
        background: #f1c40f;
        color: #000;
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 50px;
        margin-left: auto;
        font-weight: bold;
    }

    .menu-label {
        flex-shrink: 0;
    }
</style>

<div class="sidebar">
    <div class="sidebar-header"
        style="padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); position: relative; flex-shrink: 0;">
        <button onclick="toggleSidebar()" class="d-lg-none"
            style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: white; opacity: 0.5;">
            <i class="fas fa-times"></i>
        </button>
        <img src="{{ asset('img/mainLogo.png') }}" width="60" style="filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
        <h3 style="margin-top: 15px; font-family: 'Domine'; font-size: 18px; letter-spacing: 1px;">PANEL ADMIN</h3>
        <h6 style="opacity: 0.8; font-weight: 400; font-size: 12px;"><?php echo "$hari, $tanggal $bulan $tahun"; ?></h6>
    </div>

    <nav class="sidebar-menu" style="padding: 20px 0; display: flex; flex-direction: column; flex-grow: 1;">

        <small class="menu-label"
            style="display: block; padding: 10px 25px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Ikhtisar</small>
        <a href="{{ route('admin.dashboard') }}"
            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Statistik Desa
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Manajemen
            Surat</small>
        <a href="{{ route('admin.surat-masuk') }}"
            class="menu-item {{ request()->routeIs('admin.surat-masuk') ? 'active' : '' }}">
            <i class="fas fa-envelope-open-text"></i> Permohonan Baru
            <span class="badge-count">5</span>
        </a>
        <a href="{{ route('admin.surat-arsip') }}"
            class="menu-item {{ request()->routeIs('admin.surat-arsip') ? 'active' : '' }}">
            <i class="fas fa-archive"></i> Arsip Surat Selesai
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Kependudukan</small>
        <a href="{{ route('admin.penduduk') }}"
            class="menu-item {{ request()->routeIs('admin.penduduk') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Data Penduduk
        </a>
        <a href="{{ route('admin.keluarga.index') }}"
            class="menu-item {{ request()->routeIs('admin.keluarga.*') ? 'active' : '' }}">
            <i class="fas fa-address-card"></i> Kartu Keluarga
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Interaksi
            Publik</small>
        <a href="{{ route('admin.keluhan.index') }}"
            class="menu-item {{ request()->routeIs('admin.keluhan.*') ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle"></i> Keluhan Warga
        </a>
        <a href="{{ route('admin.berita.index') }}"
            class="menu-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> Kelola Berita
        </a>

        <small class="menu-label"
            style="display: block; padding: 20px 25px 10px; opacity: 0.5; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">Sistem</small>
        <a href="{{ route('admin.profile.index') }}"
            class="menu-item {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Profil Admin
        </a>
        <a href="{{ route('admin.pengaturan') }}"
            class="menu-item {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Pengaturan Desa
        </a>

        <div class="sidebar-footer" style="padding: 20px; margin-top: 20px;">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-sidebar"
                    style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #e74c3c; color: white; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s;">
                    <i class="fas fa-sign-out-alt"></i> Keluar Panel
                </button>
            </form>
        </div>
    </nav>
</div>

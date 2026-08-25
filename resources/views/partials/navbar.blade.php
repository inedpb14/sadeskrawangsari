<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="header-main">
    <div class="header-container">
        <img src="{{ asset('img/mainLogo.png') }}" alt="Logo Desa">
        <div class="header-text">
            <h1>KANTOR DESA KRAWANG SARI</h1>
            <p>Kecamatan Natar, Kabupaten Lampung Selatan</p>
        </div>
    </div>
</div>

<nav class="navbar">
    <div class="nav-links">
        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Home
        </a>

        <div class="dropdown {{ Request::is('profil*') ? 'active-parent' : '' }}">
            <button class="dropbtn">
                <i class="fas fa-university"></i> Profil Desa <i class="fas fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="/profil/sejarah"><i class="fas fa-history"></i> Sejarah & Wilayah</a>
                <a href="/profil/visi-misi"><i class="fas fa-bullseye"></i> Visi & Misi</a>
                {{-- <a href="/profil/perangkat"><i class="fas fa-users"></i> Perangkat Desa</a> --}}
            </div>
        </div>

        {{-- <div class="dropdown {{ Request::is('layanan*') ? 'active-parent' : '' }}">
            <button class="dropbtn">
                <i class="fas fa-concierge-bell"></i> Layanan Penduduk <i class="fas fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="/layanan/panduan"><i class="fas fa-book"></i> Panduan Pengurusan Surat</a>
                <a href="/layanan/ajukan"><i class="fas fa-file-signature"></i> Ajukan Surat Online</a>
                <a href="/layanan/status"><i class="fas fa-tasks"></i> Cek Status Permohonan</a>
            </div>
        </div> --}}

        <a href="/login-warga" class="{{ Request::is('login') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Ajukan Surat Online
        </a>

        <a href="/statistik" class="{{ Request::is('statistik*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Statistik Penduduk
        </a>

        <div
            class="dropdown {{ request()->routeIs('berita.*') || request()->routeIs('keluhan') ? 'active-parent' : '' }}">
            <button class="dropbtn">
                <i class="fas fa-info-circle"></i> Kabar Desa <i class="fas fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('berita.index') }}"
                    style="{{ request()->routeIs('berita.*') ? 'color: #3a918e; font-weight: bold;' : '' }}">
                    <i class="fas fa-newspaper"></i> Berita Desa
                </a>
                <a href="{{ route('keluhan') }}"
                    style="{{ request()->routeIs('keluhan') ? 'color: #3a918e; font-weight: bold;' : '' }}">
                    <i class="fas fa-comment-dots"></i> Keluhan Publik
                </a>
            </div>
        </div>

        <a href="/login-warga" class="{{ Request::is('login') ? 'active' : '' }}">
            <i class="fas fa-sign-in-alt"></i> Masuk Akun
        </a>
    </div>
</nav>

<div class="divider"></div>

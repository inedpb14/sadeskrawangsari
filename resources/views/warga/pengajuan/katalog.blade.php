@extends('layouts.app-warga')

@section('title', 'Pilih Jenis Surat')

@section('content')
    <div class="welcome-card-2">
        <h1>Layanan Surat Mandiri</h1>
        <p>Pilih jenis surat yang ingin Anda ajukan di bawah ini dengan mudah dan cepat.</p>
    </div>

    <div class="katalog-container">
        <div class="surat-grid">
            @php
                $daftar_surat = [
                    ['name' => 'Surat Keterangan Tidak Mampu', 'slug' => 'surat-sktm', 'icon' => 'fa-hands-helping', 'desc' => 'Surat Keterangan Tidak Mampu.', 'color' => '#4e73df'],
                    ['name' => 'Surat Rekomendasi Beasiswa', 'slug' => 'surat-beasiswa', 'icon' => 'fa-graduation-cap', 'desc' => 'Keperluan pengajuan beasiswa.', 'color' => '#1cc88a'],
                    ['name' => 'Surat IUMK', 'slug' => 'surat-iumk', 'icon' => 'fa-store', 'desc' => 'Izin Usaha Mikro Kecil.', 'color' => '#36b9cc'],
                    // ['name' => 'Surat Keterangan Domisili', 'slug' => 'surat-domisili', 'icon' => 'fa-map-marker-alt', 'desc' => 'Keterangan domisili tinggal.', 'color' => '#f6c23e'],
                    ['name' => 'Surat Keterangan Penghasilan', 'slug' => 'surat-penghasilan', 'icon' => 'fa-wallet', 'desc' => 'Rincian penghasilan orang tua/pribadi.', 'color' => '#e74a3b'],
                    ['name' => 'Surat Keterangan Belum Menikah', 'slug' => 'surat-belummenikah', 'icon' => 'fa-user-friends', 'desc' => 'Status belum pernah menikah.', 'color' => '#6f42c1'],
                    ['name' => 'Surat Kehilangan', 'slug' => 'surat-kehilangan', 'icon' => 'fa-file-alt', 'desc' => 'Pengantar kehilangan dokumen.', 'color' => '#fd7e14'],
                    // ['name' => 'Surat Kematian', 'slug' => 'surat-kematian', 'icon' => 'fa-skull', 'desc' => 'Surat keterangan kematian warga.', 'color' => '#5a5c69'],
                    ['name' => 'Surat Pengantar', 'slug' => 'surat-pengantar', 'icon' => 'fa-id-card', 'desc' => 'Permohonan KTP baru/perpanjang, Akta Kematian/Kelahiran, Kartu Keluarga.', 'color' => '#20c997'],
                    // ['name' => 'Surat Jaminan Kesehatan', 'slug' => 'surat-jamkes', 'icon' => 'fa-hospital-user', 'desc' => 'Keterangan jaminan kesehatan.', 'color' => '#d63384'],
                    ['name' => 'Surat Izin Keramaian', 'slug' => 'surat-keramaian', 'icon' => 'fa-users', 'desc' => 'Izin mengadakan acara publik.', 'color' => '#48b3af'],
                    // ['name' => 'Surat Pengantar Pindah Domisili', 'slug' => 'surat-pindah', 'icon' => 'fa-truck-moving', 'desc' => 'Pengantar pindah alamat.', 'color' => '#007bff'],
                ];
            @endphp

            @foreach($daftar_surat as $surat)
                <a href="{{ route('pengajuan.create', $surat['slug']) }}" class="surat-card-v2">
                    <div class="card-bg-icon">
                        <i class="fas {{ $surat['icon'] }}"></i>
                    </div>
                    <div class="card-content">
                        <div class="icon-box" style="background: {{ $surat['color'] }}20; color: {{ $surat['color'] }};">
                            <i class="fas {{ $surat['icon'] }}"></i>
                        </div>
                        <h4>{{ $surat['name'] }}</h4>
                        <p style="text-align: justify;">{{ $surat['desc'] }}</p>
                        <div class="card-footer">
                            <span>Ajukan Sekarang</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('extra-style')
    <style>
        :root {
            --card-radius: 24px;
            --transition-speed: 0.4s;
        }

        .surat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .surat-card-v2 {
            position: relative;
            background: #ffffff;
            border-radius: var(--card-radius);
            text-decoration: none;
            color: #333;
            overflow: hidden;
            transition: all var(--transition-speed) cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.03);
        }

        /* Efek Hover */
        .surat-card-v2:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(72, 179, 175, 0.3);
        }

        /* Ikon Bayangan di Background */
        .card-bg-icon {
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 100px;
            color: rgba(0, 0, 0, 0.03);
            transform: rotate(-15px);
            transition: var(--transition-speed);
            z-index: 0;
        }

        .surat-card-v2:hover .card-bg-icon {
            color: rgba(0, 0, 0, 0.06);
            transform: rotate(0deg) scale(1.1);
        }

        .card-content {
            padding: 30px;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
            transition: var(--transition-speed);
        }

        .surat-card-v2:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
        }

        .card-content h4 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d3436;
        }

        .card-content p {
            font-size: 0.9rem;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--color-2, #48b3af);
            opacity: 0.8;
            transition: var(--transition-speed);
        }

        .surat-card-v2:hover .card-footer {
            opacity: 1;
            gap: 10px;
        }

        .card-footer i {
            transition: transform 0.3s;
        }

        .surat-card-v2:hover .card-footer i {
            transform: translateX(5px);
        }
    </style>
@endsection
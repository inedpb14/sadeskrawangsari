@extends('layouts.app-admin')

@section('title', 'Dashboard')

@section('extra-style')
    <style>
        .welcome-card-admin {
            background-color: #476eae;
            background-image: url("data:image/svg+xml,...");
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .content-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .analytic-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #eee;
        }

        .analytic-item:last-child {
            border-bottom: none;
        }

        .analytic-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .analytic-value {
            font-weight: 700;
            color: #2c3e50;
            text-align: right;
        }

        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    {{-- Header dengan Toggle Periode --}}
    <div class="welcome-card-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 shadow-sm"
        style="padding: 30px; border-radius: 15px; background-color: var(--color-1); color: white;">

        <div>
            <h1 class="h3 mb-2" style="font-family: 'Domine', serif; font-weight: 700; color: white;">
                Dashboard Administrator
            </h1>
            <p class="mb-1" style="color: rgba(255,255,255,0.9); font-size: 1rem;">
                Selamat datang kembali, <strong>{{ $user->name }}</strong>.
            </p>
            {{-- Copywriting dengan warna teks yang disesuaikan agar kontras di atas Biru --}}
            <p class="mb-0 small" style="line-height: 1.6; max-width: 650px; color: rgba(255,255,255,0.75);">
                Pantau ringkasan performa pelayanan, pergerakan data kependudukan, dan tindak lanjut aspirasi warga secara
                <em>real-time</em> untuk mendukung tata kelola desa yang optimal.
            </p>
        </div>

        {{-- Toggle Button menggunakan --color-2 (Tosca) sebagai penanda aktif --}}
        <div class="btn-group shadow-sm bg-white rounded p-1" role="group"
            style="height: fit-content; border: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ url()->current() }}?periode=semua"
                class="btn btn-sm px-4 {{ $periode == 'semua' ? 'rounded shadow-sm' : '' }}"
                style="{{ $periode == 'semua' ? 'background-color: var(--color-2); color: white; border: none; font-weight: 600;' : 'color: #858796; border: none; background: transparent;' }}">
                Sepanjang Waktu
            </a>
            <a href="{{ url()->current() }}?periode=bulan_ini"
                class="btn btn-sm px-4 {{ $periode == 'bulan_ini' ? 'rounded shadow-sm' : '' }}"
                style="{{ $periode == 'bulan_ini' ? 'background-color: var(--color-2); color: white; border: none; font-weight: 600;' : 'color: #858796; border: none; background: transparent;' }}">
                Bulan Ini
            </a>
        </div>
    </div>

    {{-- BARIS 1: Kartu Statistik Utama --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #3498db;"><i class="fas fa-users"></i></div>
            <div>
                <small class="text-muted">Total Warga</small>
                <h3 class="mb-0">{{ number_format($stats['total_warga']) }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e67e22;"><i class="fas fa-file-alt"></i></div>
            <div>
                <small class="text-muted">Surat Menunggu</small>
                <h3 class="mb-0">{{ $stats['pending'] }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #2ecc71;"><i class="fas fa-check-double"></i></div>
            <div>
                <small class="text-muted">Surat Selesai</small>
                <h3 class="mb-0">{{ $stats['selesai'] }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #9b59b6;"><i class="fas fa-newspaper"></i></div>
            <div>
                <small class="text-muted">Total Berita</small>
                <h3 class="mb-0">{{ $stats['berita'] }}</h3>
            </div>
        </div>
    </div>

    {{-- BARIS 2: Panel Analisa (Berdampingan) --}}
    <div class="row g-4 mb-4">
        {{-- Analisa Demografi --}}
        <div class="col-xl-6">
            <div class="content-section" style="border-top: 4px solid #48B3AF;">
                <h2 style="font-family: 'Domine'; color: #2c3e50; margin-bottom: 20px; font-size: 1.15rem;"><i
                        class="fas fa-chart-pie me-2 text-primary"></i> Analisa Demografi Penduduk</h2>
                <div class="analytic-item"><span class="analytic-label">Rata-rata Anggota / KK</span><span
                        class="analytic-value">{{ $analisaDemografi['avg_anggota'] }} Jiwa</span></div>
                <div class="analytic-item"><span class="analytic-label">KK Terbanyak</span><span
                        class="analytic-value text-success">{{ $analisaDemografi['kk_terbanyak'] ? $analisaDemografi['kk_terbanyak']->nama_kepala_keluarga . ' (' . $analisaDemografi['kk_terbanyak']->anggota_count . ' Jiwa)' : '-' }}</span>
                </div>
                <div class="analytic-item"><span class="analytic-label">KK Tersedikit</span><span
                        class="analytic-value text-danger">{{ $analisaDemografi['kk_tersedikit'] ? $analisaDemografi['kk_tersedikit']->nama_kepala_keluarga . ' (' . $analisaDemografi['kk_tersedikit']->anggota_count . ' Jiwa)' : '-' }}</span>
                </div>
                <div class="analytic-item">
                    <span class="analytic-label">Warga Tertua</span>
                    <span class="analytic-value">
                        @if ($analisaDemografi['warga_tertua'])
                            {{ $analisaDemografi['warga_tertua']->nama_lengkap }}
                            <small
                                class="text-muted">({{ \Carbon\Carbon::parse($analisaDemografi['warga_tertua']->tanggal_lahir)->age }}
                                Thn)</small>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="analytic-item"><span class="analytic-label">Rata-rata Umur Warga</span><span
                        class="analytic-value">{{ $analisaDemografi['avg_umur'] }} Tahun</span></div>
            </div>
        </div>

        {{-- Analisa Keluhan --}}
        <div class="col-xl-6">
            <div class="content-section" style="border-top: 4px solid #e74a3b;">
                <h2 style="font-family: 'Domine'; color: #2c3e50; margin-bottom: 20px; font-size: 1.15rem;"><i
                        class="fas fa-bullhorn me-2 text-danger"></i> Analisa Pengaduan & Keluhan</h2>
                <div class="analytic-item"><span class="analytic-label">Jumlah Keluhan Masuk</span><span
                        class="analytic-value">{{ $analisaKeluhan['masuk'] }} Laporan</span></div>
                <div class="analytic-item"><span class="analytic-label">Keluhan Diselesaikan</span><span
                        class="analytic-value text-success">{{ $analisaKeluhan['selesai'] }} Selesai</span></div>
                <div class="analytic-item"><span class="analytic-label">Kategori Terbanyak</span><span
                        class="analytic-value">{{ $analisaKeluhan['kategori_terbanyak'] ? $analisaKeluhan['kategori_terbanyak']->kategori . ' (' . $analisaKeluhan['kategori_terbanyak']->total . 'x)' : '-' }}</span>
                </div>
                <div class="analytic-item" style="border-bottom: none;">
                    <span class="analytic-label">Kontributor Teraktif <br><small class="text-muted">(Laporan
                            Selesai)</small></span>
                    <span class="analytic-value">
                        @if ($analisaKeluhan['kontributor_terbanyak'])
                            {{ $analisaKeluhan['kontributor_terbanyak']->warga->nama_lengkap ?? 'Anonim' }}
                            <br><small class="text-primary">{{ $analisaKeluhan['kontributor_terbanyak']->total }} Laporan
                                Selesai</small>
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 3: Area Chart / Grafik --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="content-section">
                <h2 style="font-family: 'Domine'; color: #2c3e50; font-size: 1.15rem; margin-bottom: 20px;">Distribusi
                    Status Pengajuan Surat</h2>
                <div class="chart-container">
                    <canvas id="chartSurat"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="content-section">
                <h2 style="font-family: 'Domine'; color: #2c3e50; font-size: 1.15rem; margin-bottom: 20px;">Distribusi
                    Kategori Keluhan Warga</h2>
                <div class="chart-container">
                    <canvas id="chartKeluhan"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 4: Tabel Permohonan (Full Width) --}}
    <div class="row">
        <div class="col-12">
            <div class="content-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 style="font-family: 'Domine'; color: #2c3e50; margin:0; font-size: 1.25rem;">Permohonan Surat
                        Terbaru</h2>
                    <a href="{{ url('/admin/surat-masuk') }}" class="btn btn-sm btn-light border">Kelola Semua Surat</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nama Pemohon</th>
                                <th>NIK</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonan_terbaru as $p)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $p->warga->nama_lengkap ?? 'Warga Tidak Terdaftar' }}</td>
                                    <td class="text-muted">{{ $p->warga_nik }}</td>
                                    <td><span
                                            class="badge bg-light text-dark border">{{ $p->jenisSurat->nama_surat ?? 'Tidak Diketahui' }}</span>
                                    </td>
                                    <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-secondary';
                                            if ($p->status == 'Diajukan') {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif ($p->status == 'Diproses') {
                                                $badgeClass = 'bg-info text-dark';
                                            } elseif ($p->status == 'Disetujui') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($p->status == 'Ditolak') {
                                                $badgeClass = 'bg-danger';
                                            }
                                        @endphp
                                        <span class="badge-status {{ $badgeClass }}">{{ $p->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/admin/surat-masuk') }}" class="btn btn-sm btn-primary-2"><i
                                                class="fas fa-search me-1"></i> Proses</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-3 opacity-25"></i><br>
                                        Tidak ada permohonan baru pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Chart Status Surat (Doughnut)
            const ctxSurat = document.getElementById('chartSurat').getContext('2d');
            new Chart(ctxSurat, {
                type: 'doughnut',
                data: {
                    labels: ['Diajukan (Pending)', 'Diproses', 'Disetujui', 'Ditolak'],
                    datasets: [{
                        data: [
                            {{ $chartSurat['Diajukan'] }},
                            {{ $chartSurat['Diproses'] }},
                            {{ $chartSurat['Disetujui'] }},
                            {{ $chartSurat['Ditolak'] }}
                        ],
                        backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a', '#e74a3b'],
                        borderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // 2. Chart Kategori Keluhan (Bar)
            const ctxKeluhan = document.getElementById('chartKeluhan').getContext('2d');
            new Chart(ctxKeluhan, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartKeluhan['labels']) !!},
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: {!! json_encode($chartKeluhan['data']) !!},
                        backgroundColor: '#476eae',
                        borderRadius: 5
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        } // Precision 0 agar tidak ada angka desimal
                    }
                }
            });

        });
    </script>
@endsection

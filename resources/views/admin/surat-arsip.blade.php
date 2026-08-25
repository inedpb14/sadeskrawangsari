@extends('layouts.app-admin')

@section('title', 'Arsip Surat Selesai')

@section('extra-style')
    <style>
        .card-body {
            padding-bottom: 50px;
        }

        .table-responsive {
            overflow: visible !important;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .table thead th {
            font-family: 'Domine', serif;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #666;
            border-bottom: 2px solid #f0f0f0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        .btn-action {
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            background-color: #476eae;
            color: white;
        }

        .detail-label {
            color: #999;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            margin-bottom: 1.2rem;
            font-size: 1rem;
        }

        /* Styling filter & chart */
        .filter-select {
            font-size: 0.85rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-download-chart {
            font-size: 0.75rem;
            border-radius: 6px;
            padding: 4px 10px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="welcome-card-2 shadow mb-4">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h1 class="fw-bold">Arsip Surat Selesai</h1>
                <p class="mb-0 opacity-75">Data arsip otomatis difilter berdasarkan bulan berjalan untuk kecepatan akses.</p>
            </div>
            <div class="ms-3 d-none d-md-block">
                <i class="fas fa-archive fa-4x opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
            <div class="card-body p-3 pb-3">
                <form action="{{ route('admin.surat-arsip') }}" method="GET" id="filterForm">
                    <div class="row mb-3 pb-3 border-bottom align-items-end">
                        <div class="col-md-12 mb-2">
                            <span class="badge bg-primary px-3 py-2"><i class="far fa-calendar-alt me-1"></i> Periode
                                Waktu</span>
                            <small class="text-muted ms-2">Periode waktu ini mengubah data pada grafik dan juga tabel di
                                bawah.</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted" style="font-size: 0.75rem;">Bulan</label>
                            <select name="bulan" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="semua" {{ $bulanTerpilih == 'semua' ? 'selected' : '' }}>Semua Bulan
                                </option>
                                @php
                                    $namaBulan = [
                                        '01' => 'Januari',
                                        '02' => 'Februari',
                                        '03' => 'Maret',
                                        '04' => 'April',
                                        '05' => 'Mei',
                                        '06' => 'Juni',
                                        '07' => 'Juli',
                                        '08' => 'Agustus',
                                        '09' => 'September',
                                        '10' => 'Oktober',
                                        '11' => 'November',
                                        '12' => 'Desember',
                                    ];
                                @endphp
                                @foreach ($namaBulan as $num => $nama)
                                    <option value="{{ $num }}" {{ $bulanTerpilih == $num ? 'selected' : '' }}>
                                        {{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 0.75rem;">Tahun</label>
                            <select name="tahun" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="semua" {{ $tahunTerpilih == 'semua' ? 'selected' : '' }}>Semua Tahun
                                </option>
                                @foreach ($tahunTersedia as $thn)
                                    <option value="{{ $thn }}" {{ $tahunTerpilih == $thn ? 'selected' : '' }}>
                                        {{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label text-muted" style="font-size: 0.75rem;"><i class="fas fa-search"></i>
                                Cari Data</label>
                            <input type="text" name="search" class="form-control filter-select"
                                placeholder="Nama / NIK / No Surat" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 0.75rem;"><i class="fas fa-filter"></i>
                                Status</label>
                            <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>
                                    Disetujui</option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted" style="font-size: 0.75rem;"><i
                                    class="fas fa-layer-group"></i> Jenis Surat</label>
                            <select name="jenis_surat" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @if (isset($jenis_surat_list))
                                    @foreach ($jenis_surat_list as $js)
                                        <option value="{{ $js->id }}"
                                            {{ request('jenis_surat') == $js->id ? 'selected' : '' }}>
                                            {{ $js->nama_surat }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 0.75rem;"><i class="fas fa-sort"></i>
                                Urutkan</label>
                            <select name="sort" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Selesai
                                    Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Selesai
                                    Terlama</option>
                                <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)
                                </option>
                                <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z-A)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label text-muted" style="font-size: 0.75rem;"><i class="fas fa-list"></i>
                                Baris</label>
                            <select name="per_page" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px;"><i
                                    class="fas fa-check"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($chartLabels) > 0)
            <div class="row mb-4">
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-secondary mb-0"><i class="fas fa-chart-bar me-2"></i> Peringkat
                                    Layanan Terpopuler</h6>
                                <button class="btn btn-outline-secondary btn-download-chart"
                                    onclick="downloadChart('arsipBarChart', 'Peringkat_Layanan')">
                                    <i class="fas fa-download"></i> Unduh
                                </button>
                            </div>
                            <div class="chart-container">
                                <canvas id="arsipBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-secondary mb-0"><i class="fas fa-chart-pie me-2"></i> Proporsi
                                    Kategori Surat</h6>
                                <button class="btn btn-outline-secondary btn-download-chart"
                                    onclick="downloadChart('arsipDoughnutChart', 'Proporsi_Kategori')">
                                    <i class="fas fa-download"></i> Unduh
                                </button>
                            </div>
                            <div class="chart-container">
                                <canvas id="arsipDoughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info border-0 shadow-sm" style="border-radius: 10px;">
                <i class="fas fa-info-circle me-2"></i> Tidak ada data statistik surat untuk periode yang dipilih.
            </div>
        @endif

        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Tgl Selesai</th>
                                <th>No. Surat</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip as $s)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 38px; height: 38px; background: #eef2f7;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <span
                                                    class="d-block fw-bold text-dark">{{ $s->warga->nama_lengkap ?? 'Warga' }}</span>
                                                <small class="text-muted">{{ $s->warga_nik }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-medium">{{ $s->jenisSurat->nama_surat ?? 'Layanan Umum' }}</span>
                                    </td>
                                    <td><span class="text-muted">{{ $s->updated_at->translatedFormat('d M Y') }}</span>
                                    </td>
                                    <td>
                                        @if ($s->nomor_surat)
                                            <span class="badge bg-light text-dark border">{{ $s->nomor_surat }}</span>
                                        @else
                                            <span class="text-muted small"><i>Tanpa Nomor</i></span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeColor =
                                                $s->status == 'Disetujui'
                                                    ? 'bg-success text-white'
                                                    : 'bg-danger text-white';
                                        @endphp
                                        <span
                                            class="badge status-badge {{ $badgeColor }} shadow-sm">{{ $s->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-primary py-2 px-3 btn-action shadow-sm btn-detail-trigger"
                                            data-id="{{ $s->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>

                                        @if ($s->status == 'Disetujui')
                                            <a href="{{ url('/admin/surat/cetak/' . $s->id) }}" target="_blank"
                                                class="btn btn-sm btn-dark py-2 px-3 btn-action shadow-sm ms-1">
                                                <i class="fas fa-print"></i> PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-archive fa-3x text-muted opacity-25 mb-3"></i>
                                        <p class="text-muted">Tidak ada riwayat arsip yang ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center mb-5">
            <span class="text-muted small">Menampilkan {{ $arsip->firstItem() ?? 0 }} - {{ $arsip->lastItem() ?? 0 }}
                dari total {{ $arsip->total() }}</span>
            {{ $arsip->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-file-alt me-2"></i> Rincian Arsip</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center py-5" id="loader">
                        <div class="spinner-grow text-primary" role="status"></div>
                        <p class="mt-2 text-muted fw-medium">Memuat data...</p>
                    </div>

                    <div id="detailData" class="d-none">
                        <div class="row">
                            <div class="col-md-6 px-4">
                                <div class="detail-label">Nama Lengkap</div>
                                <div class="detail-value" id="det-nama">-</div>

                                <div class="detail-label">Nomor NIK</div>
                                <div class="detail-value" id="det-nik">-</div>

                                <div class="detail-label">Jenis Surat</div>
                                <div class="detail-value text-primary" id="det-jenis">-</div>

                                <div class="detail-label">Nomor Surat</div>
                                <div class="detail-value text-primary" id="det-nomor">-</div>
                            </div>
                            <div class="col-md-6 px-4 border-start">
                                <div class="detail-label">Tanggal Pengajuan</div>
                                <div class="detail-value" id="det-tgl">-</div>

                                <div class="detail-label">Selesai Diproses (Tgl)</div>
                                <div class="detail-value" id="det-updated">-</div>

                                <div class="detail-label">Status Akhir</div>
                                <div class="detail-value">
                                    <span class="badge" id="det-status">-</span>
                                </div>

                                <div class="detail-label">Metode Pengambilan</div>
                                <div class="detail-value" id="det-metode">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script>
        // FUNGSI UNTUK DOWNLOAD CHART SEBAGAI GAMBAR
        function downloadChart(canvasId, fileName) {
            const canvas = document.getElementById(canvasId);

            // Buat canvas sementara dengan background putih agar tidak transparan saat diunduh
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = canvas.width;
            tempCanvas.height = canvas.height;
            const ctx = tempCanvas.getContext('2d');

            // Isi background putih
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
            // Salin chart di atas background putih
            ctx.drawImage(canvas, 0, 0);

            // Trigger download
            const link = document.createElement('a');
            link.download = fileName + '.png';
            link.href = tempCanvas.toDataURL('image/png');
            link.click();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chartLabels = @json($chartLabels ?? []);
            const chartCounts = @json($chartCounts ?? []);

            if (chartLabels.length > 0) {
                const generateColors = (count) => {
                    const colors = [
                        '#476eae', '#48b3af', '#e67e22', '#e74c3c',
                        '#9b59b6', '#f1c40f', '#1abc9c', '#34495e',
                        '#d35400', '#27ae60', '#2980b9', '#8e44ad'
                    ];
                    let bg = [];
                    for (let i = 0; i < count; i++) {
                        bg.push(colors[i % colors.length]);
                    }
                    return bg;
                };

                const bgColors = generateColors(chartLabels.length);

                // 1. BAR CHART
                const ctxBar = document.getElementById('arsipBarChart').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Total Surat',
                            data: chartCounts,
                            backgroundColor: bgColors,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            y: {
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });

                // 2. DOUGHNUT CHART (DENGAN PERSENTASE SAAT HOVER)
                const ctxDoughnut = document.getElementById('arsipDoughnutChart').getContext('2d');
                new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: chartCounts,
                            backgroundColor: bgColors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            // Konfigurasi Tooltip untuk Kalkulasi Persentase
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }

                                        let value = context.raw || 0;
                                        // Menghitung total data
                                        let total = context.chart._metasets[context.datasetIndex].total;
                                        // Menghitung persentase
                                        let percentage = Math.round((value / total) * 100);

                                        label += value + ' Surat (' + percentage + '%)';
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Handle AJAX Button Detail (Tetap sama)
            $('.btn-detail-trigger').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const myModal = new bootstrap.Modal(document.getElementById('modalDetail'));
                myModal.show();

                $('#loader').removeClass('d-none');
                $('#detailData').addClass('d-none');

                $.ajax({
                    url: `/admin/surat-detail/${id}`,
                    method: 'GET',
                    success: function(data) {
                        $('#det-nama').text(data.nama);
                        $('#det-nik').text(data.nik);
                        $('#det-jenis').text(data.jenis);
                        $('#det-nomor').text(data.nomor_surat ? data.nomor_surat :
                            'Belum ada nomor surat');
                        $('#det-tgl').text(data.tanggal);
                        $('#det-updated').text(data.updated);
                        $('#det-metode').text(data.metode_ambil);

                        $('#det-status').text(data.status).removeAttr('class').addClass(
                            'badge status-badge');
                        if (data.status === 'Disetujui') $('#det-status').addClass(
                            'bg-success text-white');
                        else $('#det-status').addClass('bg-danger text-white');

                        $('#loader').addClass('d-none');
                        $('#detailData').removeClass('d-none');
                    },
                    error: function() {
                        $('#loader').html(
                            '<p class="text-danger">Gagal mengambil data. Cek koneksi atau route.</p>'
                            );
                    }
                });
            });
        });
    </script>
@endsection

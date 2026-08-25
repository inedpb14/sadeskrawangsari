@extends('layouts.app-admin')

@section('title', 'Permohonan Surat Masuk')

@section('extra-style')
    <style>
        /* 1. SOLUSI UTAMA: Mencegah Dropdown Terpotong */
        .card-body {
            padding-bottom: 150px !important;
            /* Ruang extra agar dropdown di baris terakhir tidak terpotong */
        }

        .table-responsive {
            overflow: visible !important;
            /* Wajib agar dropdown bisa keluar dari area tabel */
        }

        /* Agar tabel tetap rapi namun tidak mengunci dropdown */
        .table-responsive {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* 2. Styling UI Modern */
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
    </style>
@endsection

@section('content')
    <div class="welcome-card-2 shadow">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h1 class="fw-bold">Daftar Permohonan Surat</h1>
                <p class="mb-0 opacity-75">Kelola dan proses permohonan dokumen warga Desa Krawang Sari dengan cepat.</p>
            </div>
            <div class="ms-3 d-none d-md-block">
                <i class="fas fa-envelope-open-text fa-4x opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-4">
                <form action="{{ route('admin.surat-masuk') }}" method="GET">
                    <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-filter text-muted"></i></span>
                        <select name="status" class="form-select border-0 ps-0" onchange="this.form.submit()">
                            <option value="">Semua Status Permohonan</option>
                            @foreach (['Diajukan', 'Diproses', 'Disetujui', 'Ditolak'] as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                    {{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat as $s)
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
                                    <td><span class="text-muted">{{ $s->created_at->translatedFormat('d M Y') }}</span></td>
                                    <td>
                                        @php
                                            $badgeColor = match ($s->status) {
                                                'Diajukan' => 'bg-warning text-dark',
                                                'Diproses' => 'bg-info text-white',
                                                'Disetujui' => 'bg-success text-white',
                                                'Ditolak' => 'bg-danger text-white',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span
                                            class="badge status-badge {{ $badgeColor }} shadow-sm">{{ $s->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <button type="button"
                                                class="btn btn-sm btn-white border dropdown-toggle py-2 px-3 btn-action"
                                                data-bs-toggle="dropdown" data-bs-display="static" {{-- KUNCI: Mencegah posisi dropdown kacau di dalam tabel --}}
                                                aria-expanded="false">
                                                Update
                                            </button>
<ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                                <li>
                                                    <h6 class="dropdown-header">Ubah Status Ke:</h6>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.surat-proses', $s->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Diproses">
                                                        <button type="submit" class="dropdown-item rounded">
                                                            <i class="fas fa-spinner fa-spin me-2 text-info"></i> Diproses
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item rounded text-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalSetuju{{ $s->id }}">
                                                        <i class="fas fa-check me-2"></i> Setujui & Beri Nomor
                                                    </button>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item rounded text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalTolak{{ $s->id }}">
                                                        <i class="fas fa-times me-2"></i> Tolak Permohonan
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <button type="button"
                                            class="btn btn-sm btn-primary py-2 px-3 btn-action shadow-sm btn-detail-trigger"
                                            data-id="{{ $s->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>

                                        @if ($s->status == 'Disetujui')
                                            <a href="{{ route('admin.surat-cetak', $s->id) }}" target="_blank"
                                                class="btn btn-sm btn-dark py-2 px-3 btn-action shadow-sm">
                                                <i class="fas fa-print"></i> PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                                        <p class="text-muted">Tidak ada permohonan surat masuk ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @foreach ($surat as $s)
                        <div class="modal fade" id="modalSetuju{{ $s->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.surat-setujui', $s->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Persetujuan Surat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Silakan masukkan Nomor Urut Registrasi Desa untuk permohonan
                                                <strong>{{ $s->warga->nama_lengkap }}</strong>.</p>

                                            <div class="mb-3">
                                                <label class="form-label">Nomor Urut Surat</label>
                                                <div class="input-group">
                                                    <input type="text" name="no_urut" class="form-control text-center"
                                                        placeholder="Contoh: 145" required>

                                                    <span class="input-group-text bg-light">/ KODE / BLN / THN</span>
                                                </div>
                                                <small class="text-muted mt-2 d-block">
                                                    <i class="fas fa-info-circle"></i> Sistem akan otomatis merangkai kode
                                                    surat, bulan romawi, dan tahun saat ini.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan & Setujui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalTolak{{ $s->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.surat-tolak', $s->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Tolak Permohonan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Alasan Penolakan</label>
                                                <textarea name="keterangan_admin" class="form-control" rows="3"
                                                    placeholder="Sebutkan alasan agar warga dapat memperbaikinya..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Tolak Surat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $surat->links() }}
        </div>
    </div>

    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-file-alt me-2"></i> Rincian Permohonan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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

                                <div class="detail-label">Tanggal Diperbarui</div>
                                <div class="detail-value" id="det-updated">-</div>

                                <div class="detail-label">Status Permohonan</div>
                                <div class="detail-value">
                                    <span class="badge" id="det-status">-</span>
                                </div>

                                <div class="detail-label">Metode Pengambilan Surat</div>
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
        $(document).ready(function() {
            // Handle Button Detail
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
                        $('#det-nomor').text(data.nomor_surat ? data.nomor_surat : 'Belum ada nomor surat');
                        $('#det-tgl').text(data.tanggal);
                        $('#det-updated').text(data.updated);
                        $('#det-metode').text(data.metode_ambil);

                        // Style status badge di modal
                        $('#det-status').text(data.status).removeAttr('class').addClass(
                            'badge status-badge');
                        if (data.status === 'Diajukan') $('#det-status').addClass(
                            'bg-warning text-dark');
                        else if (data.status === 'Diproses') $('#det-status').addClass(
                            'bg-info text-white');
                        else if (data.status === 'Disetujui') $('#det-status').addClass(
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

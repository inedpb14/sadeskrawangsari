@extends('layouts.app-admin')

@section('title', 'Keluhan Warga')

@section('extra-style')
    <style>
        .btn-primary-2 {
            background-color: #476eae;
            color: white;
        }

        .custom-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            backdrop-filter: blur(3px);
            overflow-y: auto;
        }

        .modal-content-box {
            background: white;
            margin: 5vh auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 700px;
        }

        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 1.05rem;
            color: #333;
            margin-bottom: 15px;
        }

        .lampiran-box {
            border: 1px dashed #ccc;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
        }

        .lampiran-box img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <div class="welcome-card-2 mb-4" style="padding: 20px 30px; border-radius: 15px;">
        <h2 class="text-white mb-0"><i class="fas fa-exclamation-circle me-2"></i> Kotak Keluhan Warga</h2>
        <p class="text-white opacity-75 mb-0 mt-1">Pantau dan tanggapi aspirasi serta pengaduan masyarakat desa.</p>
    </div>

    <div class="container-fluid p-4" style="background: #f8f9fa;">

        {{-- Statistik Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-bottom: 4px solid #858796;">
                    <h6 class="text-muted fw-bold small">TOTAL KELUHAN</h6>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-bottom: 4px solid #f6c23e;">
                    <h6 class="text-muted fw-bold small">MENUNGGU</h6>
                    <h3 class="fw-bold mb-0 text-warning">{{ $stats['menunggu'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-bottom: 4px solid #36b9cc;">
                    <h6 class="text-muted fw-bold small">DIPROSES</h6>
                    <h3 class="fw-bold mb-0 text-info">{{ $stats['diproses'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-bottom: 4px solid #1cc88a;">
                    <h6 class="text-muted fw-bold small">SELESAI</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $stats['selesai'] }}</h3>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Filter & Search --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.keluhan.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="small fw-bold">Cari Laporan</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Judul / Nama Pelapor..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold">Filter Status</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-2 btn-sm px-4"><i class="fas fa-search"></i>
                            Cari</button>
                        <a href="{{ route('admin.keluhan.index') }}" class="btn btn-light btn-sm"><i
                                class="fas fa-sync"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Data --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tiket / Tanggal</th>
                            <th>Pelapor</th>
                            <th>Kategori & Judul</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluhan as $item)
                            <tr>
                                <td class="ps-4">
                                    <span
                                        class="badge bg-light text-dark border mb-1">#TKT-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span><br>
                                    <small class="text-muted"><i class="far fa-clock"></i>
                                        {{ $item->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->warga->nama_lengkap ?? 'Anonim / NIK Dihapus' }}</div>
                                    <small class="text-muted">{{ $item->warga_nik }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary mb-1">{{ $item->kategori }}</span><br>
                                    <span class="fw-bold text-dark">{{ Str::limit($item->judul, 40) }}</span>
                                </td>
                                <td>
                                    @if ($item->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half"></i>
                                            Menunggu</span>
                                    @elseif($item->status == 'Diproses')
                                        <span class="badge bg-info"><i class="fas fa-tools"></i> Diproses</span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Selesai</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Mengirim seluruh data item ke JavaScript untuk dimasukkan ke Modal --}}
                                    <button class="btn btn-sm btn-primary-2"
                                        onclick="openDetailModal({{ json_encode($item) }}, '{{ $item->warga->nama_lengkap ?? 'Anonim' }}', '{{ $item->lampiran_path ? asset('storage/' . $item->lampiran_path) : '' }}')"
                                        title="Detail & Tanggapi">
                                        <i class="fas fa-reply"></i> Tanggapi
                                    </button>
                                    <form action="{{ route('admin.keluhan.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus pengaduan ini permanen?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada data keluhan warga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white pt-3 pb-2 border-top-0">
                {{ $keluhan->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL & TANGGAPAN --}}
    <div id="detailModal" class="custom-modal">
        <div class="modal-content-box">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #476eae;">
                <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i> Detail Pengaduan & Tanggapan</h6>
                <button class="btn-close btn-close-white" onclick="closeDetailModal()"></button>
            </div>

            <form id="formTanggapan" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-0" style="max-height: 70vh; overflow-y: auto;">

                    {{-- Bagian Atas: Detail Laporan (Read-only) --}}
                    <div class="p-4" style="background-color: #fcfdfd; border-bottom: 1px solid #eee;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-label">Nama Pelapor</div>
                                <div class="info-value" id="mdl_pelapor"></div>

                                <div class="info-label">Kategori</div>
                                <div class="info-value"><span class="badge bg-secondary" id="mdl_kategori"></span></div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Tanggal Laporan</div>
                                <div class="info-value" id="mdl_tanggal"></div>

                                <div class="info-label">Judul Keluhan</div>
                                <div class="info-value fw-bold text-dark" id="mdl_judul"></div>
                            </div>
                        </div>

                        <div class="info-label mt-2">Isi Keluhan Lengkap</div>
                        <div class="info-value p-3 bg-white border rounded" id="mdl_isi"
                            style="white-space: pre-line;"></div>

                        <div id="wrapper_lampiran" style="display: none;">
                            <div class="info-label mt-3">Lampiran Foto/Bukti</div>
                            <div class="lampiran-box mt-1">
                                <a id="link_lampiran" href="#" target="_blank">
                                    <img id="mdl_lampiran" src="" alt="Lampiran">
                                </a>
                                <div class="small text-muted mt-2"><i class="fas fa-search-plus"></i> Klik gambar untuk
                                    memperbesar</div>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Bawah: Form Tanggapan Admin --}}
                    <div class="p-4 bg-white">
                        <h6 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-edit me-2"></i> Area Tindak Lanjut
                            Admin</h6>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Update Status Keluhan</label>
                            <select name="status" id="mdl_status" class="form-select" required>
                                <option value="Menunggu">Menunggu (Belum diproses)</option>
                                <option value="Diproses">Diproses (Sedang ditindaklanjuti)</option>
                                <option value="Selesai">Selesai (Masalah tuntas)</option>
                                <option value="Ditolak">Ditolak (Spam / Tidak Valid)</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold">Tanggapan / Balasan untuk Pelapor</label>
                            <textarea name="tanggapan_admin" id="mdl_tanggapan" class="form-control" rows="4"
                                placeholder="Tuliskan hasil tindak lanjut atau pesan untuk warga..."></textarea>
                            <small class="text-muted">Tanggapan ini akan bisa dibaca oleh pelapor di dashboard
                                mereka.</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeDetailModal()">Batal</button>
                    <button type="submit" class="btn btn-primary-2 btn-sm px-4"><i class="fas fa-save me-1"></i> Simpan
                        Tanggapan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra-script')
    <script>
        function openDetailModal(data, namaPelapor, lampiranUrl) {
            document.getElementById('detailModal').style.display = 'block';

            // Atur URL Action untuk Form Update
            document.getElementById('formTanggapan').action = `/admin/keluhan/${data.id}`;

            // Isi Data Read-Only
            document.getElementById('mdl_pelapor').innerText = namaPelapor + ' (' + data.warga_nik + ')';
            document.getElementById('mdl_kategori').innerText = data.kategori;
            document.getElementById('mdl_judul').innerText = data.judul;
            document.getElementById('mdl_isi').innerText = data.isi_pengaduan;

            // Format Tanggal Manual JS (Sederhana)
            let date = new Date(data.created_at);
            document.getElementById('mdl_tanggal').innerText = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Handle Lampiran
            if (lampiranUrl !== "") {
                document.getElementById('wrapper_lampiran').style.display = 'block';
                document.getElementById('mdl_lampiran').src = lampiranUrl;
                document.getElementById('link_lampiran').href = lampiranUrl;
            } else {
                document.getElementById('wrapper_lampiran').style.display = 'none';
            }

            // Isi Data Form
            document.getElementById('mdl_status').value = data.status;
            document.getElementById('mdl_tanggapan').value = data.tanggapan_admin !== null ? data.tanggapan_admin : '';
        }

        function closeDetailModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
    </script>
@endsection

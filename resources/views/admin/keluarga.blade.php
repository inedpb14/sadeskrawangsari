@extends('layouts.app-admin')

@section('title', 'Manajemen Keluarga')

@section('content')
    <div class="welcome-card-2">
        <h1>Manajemen Data Keluarga (KK)</h1>
        <p>Total Data: <span class="badge bg-success">{{ $totalKeluarga }}</span> Kepala Keluarga</p>
    </div>

    <div class="container-fluid p-4" style="background: #f8f9fa;">

        {{-- NOTIFIKASI --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ADVANCED FILTER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.keluarga.index') }}" method="GET" id="mainFilterForm"
                    class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="small fw-bold">Pencarian Umum</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari No. KK / Nama Kepala Keluarga" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold">Urutkan Berdasarkan</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Data Terbaru
                            </option>
                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A - Z)
                            </option>
                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z - A)
                            </option>
                            <option value="kk_asc" {{ request('sort') == 'kk_asc' ? 'selected' : '' }}>No KK (Terkecil -
                                Terbesar)</option>
                            <option value="kk_desc" {{ request('sort') == 'kk_desc' ? 'selected' : '' }}>No KK (Terbesar -
                                Terkecil)</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-2 btn-sm flex-grow-1"><i class="fas fa-search"></i>
                            Terapkan</button>
                        <a href="{{ route('admin.keluarga.index') }}" class="btn btn-light btn-sm"><i
                                class="fas fa-sync"></i></a>
                        <button type="button" class="btn btn-success-2 btn-sm" onclick="openTambahModal()">
                            <i class="fas fa-plus"></i> Tambah KK
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE WITH ACCORDION --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: collapse;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 50px;"></th>
                            <th>No. KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Jml Anggota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluarga as $k)
                            {{-- BARIS UTAMA (KEPALA KELUARGA) --}}
                            <tr>
                                <td class="ps-3 text-center">
                                    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseKK{{ $k->no_kk }}" aria-expanded="false"
                                        aria-controls="collapseKK{{ $k->no_kk }}">
                                        <i class="fas fa-chevron-down text-primary"></i>
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1"
                                        style="font-size: 0.9rem; letter-spacing: 1px;">{{ $k->no_kk }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $k->nama_kepala_keluarga }}</div>
                                    @php
                                        $dataKepala = $k->anggota->firstWhere('nama_lengkap', $k->nama_kepala_keluarga);
                                    @endphp
                                    <small class="text-muted">
                                        {{ $dataKepala ? $dataKepala->nik : 'NIK belum terdata di Warga' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white rounded-pill">{{ $k->anggota->count() }}
                                        Jiwa</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info text-white"
                                        onclick="openEditModal('{{ $k->no_kk }}', '{{ $k->nama_kepala_keluarga }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.keluarga.destroy', $k->no_kk) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus KK ini permanen?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- BARIS COLLAPSE (ANGGOTA KELUARGA) --}}
                            <tr>
                                <td colspan="5" class="p-0 border-0">
                                    <div class="collapse" id="collapseKK{{ $k->no_kk }}">
                                        <div class="p-4"
                                            style="background-color: #fcfdfd; border-bottom: 2px solid #e3e6f0;">
                                            <h6 class="fw-bold small text-muted mb-3"><i
                                                    class="fas fa-users me-2"></i>Daftar Anggota Keluarga</h6>
                                            @if ($k->anggota->count() > 0)
                                                <table class="table table-sm table-bordered bg-white mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>NIK</th>
                                                            <th>Nama Anggota</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Status Hub. Keluarga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($k->anggota as $anggota)
                                                            <tr>
                                                                <td style="width: 20%;">{{ $anggota->nik }}</td>
                                                                <td class="fw-bold">
                                                                    {{ $anggota->nama_lengkap }}
                                                                </td>
                                                                <td>{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                                </td>
                                                                <td><span
                                                                        class="badge bg-secondary">{{ $anggota->status_hubungan_dalam_keluarga ?? 'Anggota' }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="alert alert-warning py-2 mb-0 small">Belum ada data anggota
                                                    penduduk yang terkait dengan Nomor KK ini.</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">Data keluarga tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pb-5">
            <div class="text-muted small">Data {{ $keluarga->firstItem() ?? 0 }} - {{ $keluarga->lastItem() ?? 0 }} dari
                {{ $keluarga->total() }}</div>
            {{ $keluarga->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="tambahModal" class="custom-modal">
        <div class="modal-content-box" style="max-width: 500px;">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #48B3AF;">
                <h6 class="mb-0">Tambah Data KK</h6>
                <button class="btn-close btn-close-white" onclick="closeTambahModal()"></button>
            </div>
            <form action="{{ route('admin.keluarga.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nomor KK</label>
                        <input type="text" name="no_kk" class="form-control" required maxlength="16">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Kepala Keluarga</label>
                        <input type="text" name="nama_kepala_keluarga" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeTambahModal()">Batal</button>
                    <button type="submit" class="btn btn-success-2 btn-sm px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal" class="custom-modal">
        <div class="modal-content-box" style="max-width: 500px;">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #476eae;">
                <h6 class="mb-0">Edit Data KK</h6>
                <button class="btn-close btn-close-white" onclick="closeEditModal()"></button>
            </div>
            <form id="formEditKK" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nomor KK</label>
                        <input type="text" id="edit_no_kk" class="form-control" maxlength="16" readonly style="background-color: #f8f9fa;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Kepala Keluarga</label>
                        <input type="text" name="nama_kepala_keluarga" id="edit_nama" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary-2 btn-sm px-4">Update</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .btn-primary-2 {
            background-color: #476eae;
            color: white;
        }

        .btn-success-2 {
            background-color: #48B3AF;
            color: white;
        }

        .custom-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            backdrop-filter: blur(3px);
        }

        .modal-content-box {
            background: white;
            margin: 10vh auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .pagination .page-link {
            border: none;
            padding: 8px 16px;
            margin: 0 3px;
            border-radius: 8px;
            color: #476eae;
        }

        .pagination .page-item.active .page-link {
            background: #476eae;
            color: white;
        }
    </style>

    <script>
        function openTambahModal() {
            document.getElementById('tambahModal').style.display = 'block';
        }

        function closeTambahModal() {
            document.getElementById('tambahModal').style.display = 'none';
        }

        function openEditModal(no_kk, nama) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('edit_no_kk').value = no_kk;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('formEditKK').action = `/admin/keluarga/${no_kk}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
@endsection

@extends('layouts.app-admin')

@section('title', 'Manajemen Penduduk')

@section('content')
    <div class="welcome-card-2">
        <h1>Manajemen Data Penduduk</h1>
        <p>Total: <span class="badge bg-primary">{{ $totalWarga }}</span> Jiwa | <span
                class="badge bg-success">{{ $totalKeluarga }}</span> KK</p>
    </div>

    <div class="container-fluid p-4" style="background: #f8f9fa;">
        {{-- STATISTIC CHARTS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="text-muted fw-bold small mb-3">GENDER</h6>
                    <div style="height: 200px;"><canvas id="genderChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="text-muted fw-bold small mb-3">STATUS PERKAWINAN</h6>
                    <div style="height: 200px;"><canvas id="nikahChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="text-muted fw-bold small mb-3">KELOMPOK USIA</h6>
                    <div style="height: 200px;"><canvas id="ageChart"></canvas></div>
                </div>
            </div>
        </div>

        {{-- ADVANCED FILTER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.penduduk') }}" method="GET" id="mainFilterForm" class="row g-3">
                    <div class="col-md-3">
                        <label class="small fw-bold">Pencarian Umum</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="NIK / Nama / No. KK" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold">Agama</label>
                        <select name="agama" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $ag)
                                <option value="{{ $ag }}" {{ request('agama') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold">Status Nikah</label>
                        <select name="status_perkawinan" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                <option value="{{ $st }}" {{ request('status_perkawinan') == $st ? 'selected' : '' }}>{{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary-2 btn-sm flex-grow-1">Terapkan Filter</button>
                        <button type="button" class="btn btn-success-2 btn-sm" onclick="openDownloadModal()">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        <a href="{{ route('admin.penduduk') }}" class="btn btn-light btn-sm"><i class="fas fa-sync"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>NIK / Nama</th>
                            <th>Alamat</th>
                            <th>Status / Pekerjaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warga as $item)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration + $warga->firstItem() - 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $item->nik }}</small>
                                </td>
                                <td class="small">{{ $item->alamat_jalan ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->status_perkawinan }}</span><br>
                                    <small>{{ $item->pekerjaan }}</small>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info text-white" onclick="showDetail('{{ $item->nik }}')"><i
                                            class="fas fa-eye"></i></button>
                                    <form action="{{ route('penduduk.destroy', $item->nik) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">Data tidak ditemukan sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pb-5">
            <div class="text-muted small">Data {{ $warga->firstItem() }} - {{ $warga->lastItem() }} dari
                {{ $warga->total() }}
            </div>
            {{ $warga->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- MODAL DETAIL (DENGAN FOTO) --}}
    <div id="wargaModal" class="custom-modal">
        <div class="modal-content-box" style="max-width: 800px;"> {{-- Lebarkan sedikit untuk foto --}}
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #476eae;">
                <h6 class="mb-0">Detail Informasi Penduduk</h6>
                <button class="btn-close btn-close-white" onclick="closeWargaModal()"></button>
            </div>
            <div class="modal-body p-4" id="modalContent">
                {{-- Content Loaded by JS --}}
            </div>
        </div>
    </div>

    {{-- MODAL DOWNLOAD --}}
    <div id="downloadModal" class="custom-modal">
        <div class="modal-content-box" style="max-width: 500px;">
            <div class="modal-header-custom p-3 text-white d-flex justify-content-between align-center" style="background: #48B3AF; width: 100%;">
                <h6 class="mb-0">Konfigurasi Export Excel</h6>
                <button class="btn-close btn-close-white" onclick="closeDownloadModal()"></button>
            </div>
            <form action="{{ route('admin.penduduk.export') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="jenis_kelamin" value="{{ request('jenis_kelamin') }}">
                <input type="hidden" name="agama" value="{{ request('agama') }}">
                <input type="hidden" name="status_perkawinan" value="{{ request('status_perkawinan') }}">

                <div class="p-4">
                    <p class="small text-muted mb-3">Pilih kolom yang ingin disertakan dalam file:</p>
                    <div class="row g-2">
                        @php $fields = ['nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_jalan', 'agama', 'status_perkawinan', 'pekerjaan', 'no_hp', 'email']; @endphp
                        @foreach($fields as $f)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="columns[]" value="{{ $f }}"
                                        id="c_{{ $f }}" checked>
                                    <label class="form-check-label small"
                                        for="c_{{ $f }}">{{ ucwords(str_replace('_', ' ', $f)) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-success-2 w-100">Mulai Download (.xlsx)</button>
                    </div>
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
            margin: 5vh auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .table-detail th {
            background: #f8f9fa;
            width: 35%;
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .table-detail td {
            font-size: 0.9rem;
            border-bottom: 1px solid #eee;
        }

        .img-detail {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
            border: 4px solid #f8f9fa;
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
@endsection

@section('extra-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Gender Chart
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [
                                {{ $genderStats->where('jenis_kelamin', 'L')->first()->total ?? 0 }},
                            {{ $genderStats->where('jenis_kelamin', 'P')->first()->total ?? 0 }}
                        ],
                        backgroundColor: ['#476eae', '#f6c23e']
                    }]
                },
                options: { maintainAspectRatio: false }
            });

            // 2. Status Chart
            new Chart(document.getElementById('nikahChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($statusNikahStats->pluck('status_perkawinan')) !!},
                    datasets: [{
                        data: {!! json_encode($statusNikahStats->pluck('total')) !!},
                        backgroundColor: ['#1cc88a', '#e74a3b', '#36b9cc', '#f6c23e']
                    }]
                },
                options: { maintainAspectRatio: false }
            });

            // 3. Age Chart
            new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($ageStats->pluck('kelompok_usia')) !!},
                    datasets: [{
                        label: 'Jiwa',
                        data: {!! json_encode($ageStats->pluck('total')) !!},
                        backgroundColor: '#476eae'
                    }]
                },
                options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });
        });

        function showDetail(nik) {
            const modal = document.getElementById('wargaModal');
            const content = document.getElementById('modalContent');
            modal.style.display = 'block';
            content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';

            fetch(`/admin/${nik}`)
                .then(res => res.json())
                .then(data => {
                    const foto = data.foto ? `/storage/${data.foto}` : '/assets/img/default-user.png';
                    content.innerHTML = `
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <img src="${foto}" class="img-detail" alt="Foto">
                            <div class="mt-3">
                                <span class="badge bg-primary px-3">${data.nik}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm table-detail">
                                <tr><th>No. KK</th><td>${data.no_kk || '-'}</td></tr>
                                <tr><th>Nama Lengkap</th><td class="fw-bold">${data.nama_lengkap}</td></tr>
                                <tr><th>TTL</th><td>${data.tempat_lahir}, ${data.tanggal_lahir}</td></tr>
                                <tr><th>Jenis Kelamin</th><td>${data.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}</td></tr>
                                <tr><th>Alamat</th><td>${data.alamat_jalan || '-'}</td></tr>
                                <tr><th>Agama</th><td>${data.agama}</td></tr>
                                <tr><th>Status</th><td>${data.status_perkawinan}</td></tr>
                                <tr><th>Pekerjaan</th><td>${data.pekerjaan}</td></tr>
                                <tr><th>WhatsApp</th><td>${data.no_hp || '-'}</td></tr>
                                <tr><th>Email</th><td>${data.email || '-'}</td></tr>
                            </table>
                        </div>
                    </div>`;
                });
        }

        function closeWargaModal() { document.getElementById('wargaModal').style.display = 'none'; }
        function openDownloadModal() { document.getElementById('downloadModal').style.display = 'block'; }
        function closeDownloadModal() { document.getElementById('downloadModal').style.display = 'none'; }
    </script>
@endsection
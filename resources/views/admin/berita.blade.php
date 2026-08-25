@extends('layouts.app-admin')

@section('title', 'Kelola Berita')

@section('extra-style')
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
            overflow-y: auto;
        }

        .modal-content-box {
            background: white;
            margin: 5vh auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 800px;
        }

        .ck-editor__editable_inline {
            min-height: 250px;
        }

        .preview-img-box {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border: 1px dashed #ccc;
            border-radius: 8px;
            margin-top: 10px;
            overflow: hidden;
        }

        .preview-img-box img {
            max-height: 100%;
            max-width: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <div class="welcome-card-2">
        <h1>Manajemen Kabar & Berita Desa</h1>
        <p>Total Artikel: <span class="badge bg-success">{{ $totalBerita }}</span> Berita</p>
    </div>

    <div class="container-fluid p-4" style="background: #f8f9fa;">

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

        {{-- FILTER & TOMBOL TAMBAH --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.berita.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="small fw-bold">Cari Berita</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Judul berita..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-2 btn-sm px-4"><i class="fas fa-search"></i>
                            Cari</button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-light btn-sm"><i
                                class="fas fa-sync"></i></a>
                        <button type="button" class="btn btn-success-2 btn-sm px-4 ms-auto" onclick="openTambahModal()">
                            <i class="fas fa-plus me-1"></i> Tulis Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL BERITA --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 100px;">Gambar</th>
                            <th>Judul Berita</th>
                            <th>Penulis / Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($berita as $item)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ !empty($item->gambar) ? asset('storage/' . $item->gambar) : asset('assets/img/default-image.png') }}"
                                        alt="Thumbnail"
                                        style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px; background: #eee;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 1.05rem;">{{ $item->judul }}</div>
                                    <small class="text-muted d-block text-truncate"
                                        style="max-width: 300px;">{{ strip_tags($item->isi) }}</small>

                                    {{-- Hidden div untuk menyimpan format HTML asli agar bisa dipanggil ke Modal Edit --}}
                                    <div id="html-berita-{{ $item->id }}" class="d-none">{!! $item->isi !!}</div>
                                </td>
                                <td>
                                    <span class="d-block small fw-bold"><i class="fas fa-user-edit me-1 opacity-50"></i>
                                        {{ $item->admin->nama ?? 'Admin' }}</span>
                                    <span class="small text-muted"><i class="fas fa-calendar-alt me-1 opacity-50"></i>
                                        {{ $item->created_at->format('d M Y') }}</span>
                                </td>
                                <td>
                                    @if ($item->status == 'publish')
                                        <span class="badge bg-success">Dipublikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info text-white"
                                        onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->judul) }}', '{{ $item->status }}', '{{ asset('storage/' . $item->gambar) }}')"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus berita ini permanen?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada berita.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white pt-3 pb-2 border-top-0">
                {{ $berita->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH BERITA --}}
    <div id="tambahModal" class="custom-modal">
        <div class="modal-content-box">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #48B3AF;">
                <h6 class="mb-0"><i class="fas fa-pencil-alt me-2"></i> Tulis Berita Baru</h6>
                <button class="btn-close btn-close-white" onclick="closeTambahModal()"></button>
            </div>
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Judul Berita</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Isi Berita</label>
                        <textarea name="isi" id="editorTambah"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Status Publikasi</label>
                        <select name="status" class="form-select" required>
                            <option value="publish">Publikasi Sekarang</option>
                            <option value="draft">Simpan ke Draft</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Upload Gambar Utama</label>
                        <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*"
                            id="inputFotoTambah" required>
                        <div class="preview-img-box"><img id="previewTambah" style="display:none;"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeTambahModal()">Batal</button>
                    <button type="submit" class="btn btn-success-2 btn-sm px-4">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT BERITA --}}
    <div id="editModal" class="custom-modal">
        <div class="modal-content-box">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #476eae;">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Berita</h6>
                <button class="btn-close btn-close-white" onclick="closeEditModal()"></button>
            </div>
            <form id="formEditBerita" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Judul Berita</label>
                        <input type="text" name="judul" id="editJudul" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Isi Berita</label>
                        <textarea name="isi" id="editorEdit"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Status Publikasi</label>
                        <select name="status" id="editStatus" class="form-select" required>
                            <option value="publish">Publikasi Sekarang</option>
                            <option value="draft">Simpan ke Draft</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ganti Gambar (Opsional)</label>
                        <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*"
                            id="inputFotoEdit">
                        <div class="preview-img-box"><img id="previewEdit"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary-2 btn-sm px-4">Update Berita</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let ckAdd, ckEdit;

        // Inisialisasi CKEditor untuk Modal Tambah & Edit
        ClassicEditor.create(document.querySelector('#editorTambah')).then(editor => {
            ckAdd = editor;
        }).catch(err => console.error(err));
        ClassicEditor.create(document.querySelector('#editorEdit')).then(editor => {
            ckEdit = editor;
        }).catch(err => console.error(err));

        // Fungsi Buka/Tutup Modal Tambah
        function openTambahModal() {
            document.getElementById('tambahModal').style.display = 'block';
        }

        function closeTambahModal() {
            document.getElementById('tambahModal').style.display = 'none';
        }

        // Fungsi Buka/Tutup Modal Edit
        function openEditModal(id, judul, status, gambarUrl) {
            document.getElementById('editModal').style.display = 'block';

            // Set URL Action Form
            document.getElementById('formEditBerita').action = `/admin/berita/${id}`;

            // Isi Data Teks & Gambar
            document.getElementById('editJudul').value = judul;
            document.getElementById('editStatus').value = status;
            document.getElementById('previewEdit').src = gambarUrl;
            document.getElementById('previewEdit').style.display = 'block';

            // Ambil HTML dari hidden div dan masukkan ke CKEditor Edit
            let contentHTML = document.getElementById('html-berita-' + id).innerHTML;
            ckEdit.setData(contentHTML);
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Preview Gambar Live saat dipilih
        document.getElementById('inputFotoTambah').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                document.getElementById('previewTambah').src = URL.createObjectURL(e.target.files[0]);
                document.getElementById('previewTambah').style.display = 'block';
            }
        });
        document.getElementById('inputFotoEdit').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                document.getElementById('previewEdit').src = URL.createObjectURL(e.target.files[0]);
            }
        });
    </script>
@endsection

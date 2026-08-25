@extends('layouts.app-admin')

@section('title', 'Pengaturan Desa')

@section('extra-style')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .form-section-title {
            font-family: 'Domine', serif;
            color: #2c3e50;
            border-bottom: 2px solid #3a918e;
            padding-bottom: 10px;
            margin-bottom: 25px;
            margin-top: 30px;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .preview-img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    <div class="welcome-card-2 shadow mb-4" style="background-color: #476eae; color:white; padding:30px; border-radius:15px;">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h1 class="fw-bold mb-2">Pengaturan Wajah Desa</h1>
                <p class="mb-0 opacity-75">Kelola informasi utama yang akan dilihat oleh pengunjung dan warga pada halaman
                    depan.</p>
            </div>
            <div class="ms-3 d-none d-md-block"><i class="fas fa-magic fa-4x opacity-25"></i></div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="form-section-title"><i class="fas fa-image me-2"></i> Visual & Branding</h4>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">Banner Utama (Hero Image)</label>
                            <input type="file" name="hero_image" class="form-control">
                            @if ($pengaturan && $pengaturan->hero_image)
                                <img src="{{ asset('storage/' . $pengaturan->hero_image) }}" class="preview-img"
                                    alt="Hero Preview">
                            @endif
                            <small class="text-muted d-block mt-1">Saran ukuran: 1920x1080px (Landscape)</small>
                        </div>

                        <h4 class="form-section-title"><i class="fas fa-user-tie me-2"></i> Profil Kepala Desa</h4>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Nama Lengkap Kepala Desa</label>
                            <input type="text" name="nama_kades" class="form-control"
                                value="{{ $pengaturan->nama_kades ?? '' }}" placeholder="Nama Beserta Gelar">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Foto Kepala Desa</label>
                            <input type="file" name="foto_kades" class="form-control">
                            @if ($pengaturan && $pengaturan->foto_kades)
                                <img src="{{ asset('storage/' . $pengaturan->foto_kades) }}"
                                    style="width: 120px; height: 150px; object-fit: cover; border-radius: 10px; margin-top: 10px;"
                                    alt="Kades Preview">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="form-section-title"><i class="fas fa-phone me-2"></i> Kontak Desa</h4>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ $pengaturan->email ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Telepon/WA</label>
                            <input type="text" name="telepon" class="form-control"
                                value="{{ $pengaturan->telepon ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">

                        <h4 class="form-section-title"><i class="fas fa-comment-dots me-2"></i> Teks Sambutan Kades</h4>
                        <div class="mb-4">
                            <textarea name="sambutan_kades" id="editor-sambutan">{{ $pengaturan->sambutan_kades ?? '' }}</textarea>
                        </div>

                        <h4 class="form-section-title"><i class="fas fa-bullseye me-2"></i> Visi & Misi</h4>
                        <div class="mb-4">
                            <textarea name="visi_misi" id="editor-visi">{{ $pengaturan->visi_misi ?? '' }}</textarea>
                        </div>

                        <h4 class="form-section-title"><i class="fas fa-history me-2"></i> Sejarah Desa</h4>
                        <div class="mb-4">
                            <textarea name="sejarah" id="editor-sejarah">{{ $pengaturan->sejarah ?? '' }}</textarea>
                        </div>

                        <div class="text-end pt-3">
                            <button type="submit" class="btn btn-primary px-5 py-3 shadow"
                                style="border-radius: 12px; font-weight: bold;">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('extra-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const config = {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo',
                    'redo'
                ]
            };

            ClassicEditor.create(document.querySelector('#editor-sambutan'), config);
            ClassicEditor.create(document.querySelector('#editor-visi'), config);
            ClassicEditor.create(document.querySelector('#editor-sejarah'), config);
        });
    </script>
@endsection

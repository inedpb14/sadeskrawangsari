@extends('layouts.app-warga')

@section('title', 'Formulir ' . $jenis_surat_nama)

@section('content')
    <div class="welcome-card-2">
        <h1>Layanan Surat: {{ $jenis_surat_nama }}</h1>
        <p>Pastikan data yang Anda masukkan sesuai dengan dokumen asli Anda untuk mempercepat proses verifikasi.</p>
    </div>

    @if (session('error'))
        <div style="background: red; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: red; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-layout-wrapper">
        <form action="{{ route('pengajuan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="slug" value="{{ $slug }}">
            <input type="hidden" name="jenis_surat_id" value="{{ $jenis_id }}">

            <div class="profile-container">
                <div class="profile-info-side">
                    <div class="info-card">
                        <div class="user-avatar-section">
                            <div class="image-wrapper"
                                style="background: rgba(255,255,255,0.2); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-file-signature" style="font-size: 40px; color: white;"></i>
                            </div>
                            <h3 class="profile-user-name" style="font-size: 18px; margin-top: 15px;">Prosedur Layanan</h3>
                            <div class="profile-user-nik">E-Surat Desa Digital</div>
                        </div>

                        <div class="info-scroller">
                            <div class="info-group-title">Tahapan Proses</div>

                            <div class="info-item-box mb-3">
                                <div style="font-size: 13px; font-weight: 700; margin-bottom: 5px;">
                                    <i class="fas fa-clock me-2"></i> 1. Pengisian Form
                                </div>
                                <div style="font-size: 11px; opacity: 0.8; line-height: 1.4;">
                                    Isi data tambahan yang diperlukan sesuai dengan jenis surat yang Anda pilih.
                                </div>
                            </div>
                            <div class="info-item-box mb-3">
                                <div style="font-size: 13px; font-weight: 700; margin-bottom: 5px;">
                                    <i class="fas fa-clock me-2"></i> 2. Verifikasi Admin
                                </div>
                                <div style="font-size: 11px; opacity: 0.8; line-height: 1.4;">
                                    Petugas desa akan memeriksa kelengkapan berkas dan data profil Anda.
                                </div>
                            </div>

                            <div class="info-item-box">
                                <div style="font-size: 13px; font-weight: 700; margin-bottom: 5px;">
                                    <i class="fas fa-check-double me-2"></i> 3. Surat Selesai
                                </div>
                                <div style="font-size: 11px; opacity: 0.8; line-height: 1.4;">
                                    Surat dapat diambil di kantor atau diunduh langsung jika memilih metode Mandiri.
                                </div>
                            </div>

                            <div class="mt-4 p-3"
                                style="background: rgba(0,0,0,0.1); border-radius: 15px; font-size: 12px; border: 1px dashed rgba(255,255,255,0.3);">
                                <i class="fas fa-shield-alt me-1"></i>
                                <strong>Penting:</strong> Seluruh data yang Anda kirimkan akan dienkripsi dan hanya
                                digunakan untuk keperluan administrasi desa.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-form-side">
                    <div class="form-card">
                        <h2 class="form-title">
                            <i class="fas fa-file-alt"></i> Detail Pengajuan
                        </h2>

                        <div class="form-grid">

                            <div class="form-group full-width">
                                <label>Surat Diajukan Untuk</label>
                                <select name="warga_nik_pemohon" required>
                                    <option value="{{ Auth::guard('warga')->user()->nik }}">
                                        Saya Sendiri ({{ Auth::guard('warga')->user()->nama_lengkap }})
                                    </option>

                                    @if (isset($anggota_keluarga) && count($anggota_keluarga) > 0)
                                        <optgroup label="Anggota Keluarga">
                                            @foreach ($anggota_keluarga as $anggota)
                                                @if ($anggota->nik != Auth::guard('warga')->user()->nik)
                                                    <option value="{{ $anggota->nik }}">
                                                        {{ $anggota->nama_lengkap }} - NIK: {{ $anggota->nik }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label>Metode Pengambilan Surat</label>
                                <select name="metode_ambil" required>
                                    <option value="kantor">Ambil di Kantor Desa</option>
                                    <option value="mandiri">Cetak Mandiri (PDF)</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <hr>
                                <label style="color: var(--color-2); font-size: 14px;">Informasi Khusus
                                    {{ $jenis_surat_nama }}</label>
                            </div>

                            @includeIf('warga.pengajuan.form.' . $slug)
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-update">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                            <a href="{{ route('pengajuan.katalog') }}" class="btn-update btn-cancel">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('extra-style')
    <style>
        .profile-layout-wrapper {
            padding-bottom: 20px;
        }

        .profile-container {
            display: flex;
            gap: 30px;
            align-items: stretch;
            flex-wrap: wrap;
            padding-bottom: 20px;
        }

        /* Side Info Card */
        .profile-info-side {
            flex: 1.2;
            min-width: 380px;
        }

        .info-card {
            background-color: #48b3af;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 304 304' width='304' height='304'%3E%3Cpath fill='%23476eae' fill-opacity='0.18' d='M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 18H0v-2h16V0h2v18h-1zm273-2h14v2h-16V0h2v16zm-32 273v15h-2v-14h-14v14h-2v-16h18v1zM0 92.1A5.02 5.02 0 0 1 6 97a5 5 0 0 1-6 4.9v-2.07a3 3 0 1 0 0-5.66V92.1zM80 272h2v32h-2v-32zm37.9 32h-2.07a3 3 0 0 0-5.66 0h-2.07a5 5 0 0 1 9.8 0zM5.9 0A5.02 5.02 0 0 1 0 5.9V3.83A3 3 0 0 0 3.83 0H5.9zm294.2 0h2.07A3 3 0 0 0 304 3.83V5.9a5 5 0 0 1-3.9-5.9zm3.9 300.1v2.07a3 3 0 0 0-1.83 1.83h-2.07a5 5 0 0 1 3.9-3.9zM97 100a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-48 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 96a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-144a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM49 36a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM33 68a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 240a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm80-176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm112 176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'%3E%3C/path%3E%3C/svg%3E");
            color: white;
            padding: 40px 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        .user-avatar-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-user-name {
            margin: 15px 0 5px 0;
            font-size: 22px;
            font-weight: 700;
        }

        .profile-user-nik {
            font-size: 13px;
            opacity: 0.9;
            font-family: monospace;
        }

        /* Form Card */
        .profile-form-side {
            flex: 2;
            min-width: 450px;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
            box-sizing: border-box;
        }

        .form-title {
            font-family: 'Domine';
            color: #3a918e;
            margin: 0 0 30px 0;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #777;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .custom-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #eee;
            border-radius: 12px;
            font-size: 14px;
            transition: 0.3s;
            box-sizing: border-box;
            background: #fdfdfd;
        }

        .custom-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .custom-textarea:focus {
            border-color: #48b3af;
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(72, 179, 175, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-update {
            flex: 1;
            /* Agar tombol membagi ruang rata */
            padding: 16px;
            background: #3a918e;
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 15px rgba(58, 145, 142, 0.2);
            text-align: center;
            text-decoration: none;
            display: inline-block;
            /* Penting untuk tag <a> */
            box-sizing: border-box;
        }

        .btn-cancel {
            background: #6c757d;
            box-shadow: 0 8px 15px rgba(108, 117, 125, 0.2);
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(58, 145, 142, 0.3);
            color: white;
        }

        .btn-cancel:hover {
            box-shadow: 0 10px 20px rgba(108, 117, 125, 0.3);
        }

        /* === PERUBAHAN CSS RESPONSIVE (MOBILE) === */
        @media (max-width: 992px) {
            .profile-container {
                flex-direction: column;
                /* Ubah layout jadi kolom (atas-bawah) */
            }

            .profile-info-side,
            .profile-form-side {
                min-width: 100%;
                /* Hapus batas min-width agar pas di layar HP */
                flex: none;
                /* Reset flex */
            }

            .info-card,
            .form-card {
                padding: 25px 20px;
                /* Kurangi padding dalam card agar konten lebih lega */
            }

            .form-grid {
                grid-template-columns: 1fr;
                /* Form menjadi 1 kolom saja */
            }

            .form-group.full-width {
                grid-column: span 1;
                /* Karena sudah 1 kolom, reset full-width */
            }

            .form-actions {
                flex-direction: column;
                /* Tombol Kirim dan Batal bertumpuk */
                gap: 10px;
            }

            .welcome-card-2 h1 {
                font-size: 24px;
                /* Kecilkan sedikit font judul di mobile */
            }
        }
    </style>
@endsection

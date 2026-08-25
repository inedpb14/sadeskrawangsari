@extends('layouts.app-warga')

@section('title', 'Layanan Pengaduan')

@section('content')
    <div class="welcome-card-2">
        <h1>Pusat Pengaduan & Aspirasi</h1>
        <p>Gunakan formulir ini untuk melaporkan masalah atau memberikan saran demi kemajuan desa.</p>
    </div>

    <div class="profile-layout-wrapper">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-container">
            <div class="profile-info-side">
                <div class="info-card">
                    <div class="user-avatar-section">
                        <div class="avatar-icon-circle">
                            <i class="fas fa-bullhorn" style="font-size: 40px; color: #48b3af;"></i>
                        </div>
                        <h3 class="profile-user-name">Monitor Laporan</h3>
                    </div>

                    <div class="info-scroller">
                        <div class="info-group-title">Statistik Laporan</div>
                        <div class="info-item-box">
                            <div class="info-row"><span>Total:</span> <strong>{{ $pengaduan->count() }}</strong></div>
                            <div class="info-row"><span>Selesai:</span>
                                <strong>{{ $pengaduan->where('status', 'Selesai')->count() }}</strong>
                            </div>
                            <div class="info-row"><span>Proses:</span>
                                <strong>{{ $pengaduan->where('status', 'Diproses')->count() }}</strong>
                            </div>
                        </div>

                        <div class="info-group-title" style="margin-top: 25px;">Riwayat Terakhir</div>
                        <div class="history-mini-list">
                            @forelse($pengaduan->take(5) as $item)
                                <div class="info-item-box"
                                    style="margin-bottom: 10px; background: rgba(255,255,255,0.15); border-left: 3px solid {{ $item->status == 'Selesai' ? '#28a745' : ($item->status == 'Diproses' ? '#17a2b8' : '#ffc107') }};">
                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                        <span
                                            style="font-weight: 700; font-size: 12px; color: #fff;">{{ Str::limit($item->judul, 20) }}</span>
                                        <span
                                            style="font-size: 9px; opacity: 0.8;">{{ $item->created_at->format('d/m') }}</span>
                                    </div>
                                    <div
                                        style="font-size: 11px; margin-top: 4px; display: flex; justify-content: space-between;">
                                        <span>{{ $item->status }}</span>
                                        <i class="fas fa-chevron-right" style="font-size: 8px; align-self: center;"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="info-item-box" style="text-align: center; opacity: 0.7;">
                                    <p style="font-size: 11px; margin: 0;">Belum ada riwayat.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-form-side">
                <div class="form-card">
                    <h2 class="form-title">
                        <i class="fas fa-edit"></i> Formulir Pengaduan
                    </h2>

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label>Kategori Masalah</label>
                                <select name="kategori" required>
                                    <option value="Infrastruktur">Infrastruktur</option>
                                    <option value="Keamanan">Keamanan & Ketertiban</option>
                                    <option value="Kebersihan">Kebersihan</option>
                                    <option value="Pelayanan">Pelayanan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label>Judul Laporan</label>
                                <input type="text" name="judul" value="{{ old('judul') }}"
                                    placeholder="Apa yang ingin dilaporkan?" required>
                            </div>

                            <div class="form-group full-width">
                                <label>Isi Pengaduan</label>
                                <textarea name="isi_pengaduan" rows="5"
                                    style="width: 100%; border-radius: 12px; border: 1.5px solid #eee; padding: 12px; font-family: inherit;"
                                    placeholder="Ceritakan detail kejadian..."
                                    required>{{ old('isi_pengaduan') }}</textarea>
                            </div>

                            <div class="form-group full-width">
                                <label>Lampiran Foto</label>
                                <input type="file" name="lampiran" accept="image/*">
                            </div>
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="fas fa-paper-plane"></i> Kirim Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-style')
    <style>
        /* Re-use CSS Profile */
        .profile-layout-wrapper {
            padding-bottom: 20px;
        }

        .profile-container {
            display: flex;
            gap: 30px;
            align-items: stretch;
            flex-wrap: wrap;
        }

        /* Sisi Kiri */
        .profile-info-side {
            flex: 1;
            min-width: 300px;
        }

        .info-card {
            background-color: #48b3af;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 304 304' width='304' height='304'%3E%3Cpath fill='%23476eae' fill-opacity='0.18' d='M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'%3E%3C/path%3E%3C/svg%3E");
            color: white;
            padding: 35px 25px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .avatar-icon-circle {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .profile-user-name {
            margin: 15px 0 25px 0;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
        }

        .info-group-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            opacity: 0.8;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 5px;
        }

        .info-item-box {
            padding: 12px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            background: rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 5px;
        }

        /* Sisi Kanan */
        .profile-form-side {
            flex: 2.2;
            min-width: 400px;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-family: 'Domine';
            color: #48b3af;
            margin: 0 0 30px 0;
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #eee;
            border-radius: 10px;
            font-size: 14px;
            background: #fdfdfd;
        }

        .btn-update {
            width: 100%;
            padding: 16px;
            background: #48b3af;
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn-update:hover {
            background: #3a918e;
            transform: translateY(-2px);
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            border-left: 5px solid #198754;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .profile-container {
                flex-direction: column;
            }

            .info-card {
                position: static;
            }
        }
    </style>
@endsection
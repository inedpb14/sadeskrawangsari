@extends('layouts.app-warga')

@section('title', 'Profil Saya')

@section('content')
    <div class="welcome-card-2">
        <h1>Profil Penduduk Digital</h1>
        <p>Selamat datang di ruang data pribadi Anda. Pastikan informasi Anda tetap akurat untuk pelayanan desa yang lebih
            cepat.</p>
    </div>

    <div class="profile-layout-wrapper">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-danger" style="background: #fee; color: #c00; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fcc;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-container">

                <div class="profile-info-side">
                    <div class="info-card">
                        <div class="user-avatar-section">
                            <div class="image-wrapper">
                                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap) . '&background=ffffff&color=48B3AF' }}"
                                    class="avatar" id="preview-foto">

                                <label for="input-foto" class="btn-change-photo">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="foto" id="input-foto" hidden accept="image/*"
                                    onchange="previewImage(this)">
                            </div>
                            <h3 class="profile-user-name">{{ $user->nama_lengkap }}</h3>
                            <div class="profile-user-nik">NIK: {{ $user->nik }}</div>
                        </div>

                        <div class="info-scroller">
                            <div class="info-group-title">Identitas & Kontak</div>
                            <div class="info-item-box">
                                <div class="info-row"><span>No. KK:</span> <strong>{{ $user->no_kk ?? '-' }}</strong></div>
                                <div class="info-row"><span>Email:</span> <strong>{{ $user->user?->email ?? '-' }}</strong></div>
                                <div class="info-row"><span>No. HP:</span> <strong>{{ $user->no_hp ?? '-' }}</strong></div>
                            </div>

                            <div class="info-group-title">Detail Personal</div>
                            <div class="info-item-box">
                                <div class="info-row">
                                    <span>TTL:</span>
                                    <strong>{{ $user->tempat_lahir ?? '-' }},
                                        {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') : '-' }}</strong>
                                </div>
                                <div class="info-row">
                                    <span>Gender:</span>
                                    <strong>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</strong>
                                </div>
                                <div class="info-row"><span>Agama:</span> <strong>{{ $user->agama }}</strong></div>
                                <div class="info-row"><span>Pekerjaan:</span> <strong>{{ $user->pekerjaan }}</strong></div>
                                <div class="info-row"><span>Status:</span> <strong>{{ $user->status_perkawinan }}</strong>
                                </div>
                                <div class="info-row"><span>Warga Negara:</span>
                                    <strong>{{ $user->kewarganegaraan }}</strong>
                                </div>
                            </div>

                            <div class="info-group-title">Alamat Domisili</div>
                            <div class="info-item-box">
                                <div class="info-row"><span>Jalan/Dusun:</span> <strong>{{ $user->alamat_jalan }}</strong>
                                </div>
                                <div class="info-row"><span>RT/RW:</span> <strong>{{ $user->rt_rw }}</strong></div>
                                <div class="info-row"><span>Kel/Desa:</span> <strong>{{ $user->kel_desa }}</strong></div>
                                <div class="info-row"><span>Kecamatan:</span> <strong>{{ $user->kecamatan }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-form-side">
                    <div class="form-card">
                        <h2 class="form-title">
                            <i class="fas fa-edit"></i> Edit Data Profil
                        </h2>

                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label>Nama Lengkap (Sesuai Identitas)</label>
                                <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                            </div>

                            <div class="form-group">
                                <label>Nomor Kartu Keluarga (KK)</label>
                                <input type="text" name="no_kk" value="{{ $user->no_kk }}" maxlength="16">
                            </div>

                            <div class="form-group">
                                <label>Nomor HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ $user->no_hp }}">
                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ $user->tempat_lahir }}" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" required>
                            </div>

                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin">
                                    <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Agama</label>
                                <select name="agama">
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                        <option value="{{ $agm }}" {{ $user->agama == $agm ? 'selected' : '' }}>{{ $agm }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <select name="status_perkawinan">
                                    @foreach(['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'] as $stat)
                                        <option value="{{ $stat }}" {{ $user->status_perkawinan == $stat ? 'selected' : '' }}>
                                            {{ $stat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan Saat Ini</label>
                                <input type="text" name="pekerjaan" value="{{ $user->pekerjaan }}" required>
                            </div>

                            <div class="form-group">
                                <label>Kewarganegaraan</label>
                                <select name="kewarganegaraan">
                                    <option value="WNI" {{ $user->kewarganegaraan == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ $user->kewarganegaraan == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" name="email" value="{{ $user->user?->email }}">
                            </div>

                            <div class="form-group full-width">
                                <label>Alamat Jalan / Dusun</label>
                                <input type="text" name="alamat_jalan" value="{{ $user->alamat_jalan }}" required>
                            </div>

                            <div class="form-group">
                                <label>RT / RW</label>
                                <input type="text" name="rt_rw" value="{{ $user->rt_rw }}" required placeholder="001/002">
                            </div>

                            <div class="form-group">
                                <label>Kelurahan / Desa</label>
                                <input type="text" name="kel_desa" value="{{ $user->kel_desa }}" required>
                            </div>

                            <div class="form-group full-width">
                                <label>Kecamatan</label>
                                <input type="text" name="kecamatan" value="{{ $user->kecamatan }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="fas fa-save"></i> Update Profil Sekarang
                        </button>
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
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 304 304' width='304' height='304'%3E%3Cpath fill='%23476eae' fill-opacity='0.18' d='M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'%3E%3C/path%3E%3C/svg%3E");
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

        .image-wrapper {
            position: relative;
            display: inline-block;
        }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.2);
            object-fit: cover;
            background: white;
        }

        .btn-change-photo {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #3a918e;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
            transition: 0.3s;
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

        .info-scroller {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        .info-group-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0.8;
        }

        .info-item-box {
            background: rgba(0, 0, 0, 0.1);
            padding: 15px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 5px;
        }

        .info-row span {
            opacity: 0.7;
            font-weight: 400;
        }

        .info-row strong {
            font-weight: 600;
            text-align: right;
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
            color: var(--color-2);
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
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #eee;
            border-radius: 12px;
            font-size: 14px;
            transition: 0.3s;
            box-sizing: border-box;
            background: #fdfdfd;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--color-1);
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(72, 179, 175, 0.1);
        }

        .btn-update {
            width: 100%;
            padding: 16px;
            background: var(--color-2);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 30px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 15px rgba(58, 145, 142, 0.2);
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(58, 145, 142, 0.3);
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
        }
    </style>
@endsection

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview-foto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
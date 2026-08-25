@extends('layouts.app-admin')

@section('title', 'Profil & Manajemen Akun')

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
        }

        .modal-content-box {
            background: white;
            margin: 5vh auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 500px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background-color: #eef2f7;
            color: #476eae;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 3rem;
            margin: 0 auto 20px;
            font-weight: bold;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-avatar {
            width: 40px;
            height: 40px;
            background-color: #eef2f7;
            color: #476eae;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="welcome-card-2 shadow mb-4">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h1 class="fw-bold mb-2">Pengaturan Sistem & Profil</h1>
                <p class="mb-0 opacity-75">Kelola informasi akun Anda dan atur hak akses pengguna panel admin desa.</p>
            </div>
            <div class="ms-3 d-none d-md-block">
                <i class="fas fa-user-shield fa-4x opacity-25"></i>
            </div>
        </div>
    </div>


    <div class="container-fluid p-4" style="background: #f8f9fa;">

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            {{-- BAGIAN 1: PROFIL SAYA --}}
            <div class="col-xl-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white pt-4 pb-0 border-0 text-center">
                        <div class="profile-avatar">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <span class="badge bg-primary mb-3 text-uppercase">{{ $user->role }}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update_self') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                            </div>
                            <hr>
                            <div class="alert alert-light border small text-muted p-2 mb-3">
                                <i class="fas fa-info-circle"></i> Biarkan kolom password kosong jika tidak ingin
                                mengubahnya.
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Minimal 8 karakter">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ketik ulang password">
                            </div>
                            <button type="submit" class="btn btn-primary-2 w-100 py-2 fw-bold"><i
                                    class="fas fa-save me-1"></i> Simpan Profil Saya</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: MANAJEMEN AKUN ADMIN --}}
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; height: 100%;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center"
                        style="border-radius: 15px 15px 0 0;">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users-cog me-2"></i> Kelola Hak Akses Panel
                        </h6>
                        <button class="btn btn-success-2 btn-sm px-3 py-2" onclick="openTambahModal()">
                            <i class="fas fa-plus me-1"></i> Tambah Admin
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pengguna</th>
                                        <th>Email</th>
                                        <th>Role Akses</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $adm)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="table-avatar me-3 shadow-sm">{{ substr($adm->name, 0, 1) }}
                                                    </div>
                                                    <div class="fw-bold text-dark">{{ $adm->name }}
                                                        {!! $adm->id == Auth::id()
                                                            ? '<span class="badge bg-light text-dark border ms-1" style="font-size:0.6rem;">ANDA</span>'
                                                            : '' !!}</div>
                                                </div>
                                            </td>
                                            <td class="text-muted small">{{ $adm->email }}</td>
                                            <td>
                                                @if ($adm->role == 'kades')
                                                    <span class="badge bg-success">Kepala Desa</span>
                                                @else
                                                    <span class="badge bg-primary">Admin Desa</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info text-white"
                                                    onclick="openEditModal({{ $adm->id }}, '{{ addslashes($adm->name) }}', '{{ $adm->email }}', '{{ $adm->role }}')"
                                                    title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                @if ($adm->id != Auth::id())
                                                    <form action="{{ route('admin.manage.destroy', $adm->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Hapus akses pengguna ini permanen?')"
                                                            title="Cabut Akses">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-secondary disabled"
                                                        title="Tidak bisa menghapus diri sendiri"><i
                                                            class="fas fa-ban"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH ADMIN --}}
    <div id="tambahModal" class="custom-modal">
        <div class="modal-content-box">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #48B3AF;">
                <h6 class="mb-0"><i class="fas fa-user-plus me-2"></i> Tambah Akses Pengguna Baru</h6>
                <button class="btn-close btn-close-white" onclick="closeTambahModal()"></button>
            </div>
            <form action="{{ route('admin.manage.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Nama Pengguna</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Role / Tingkat Akses</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin Desa (Staf)</option>
                            <option value="kades">Kepala Desa</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Password Panel</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter"
                            required>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeTambahModal()">Batal</button>
                    <button type="submit" class="btn btn-success-2 btn-sm px-4">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT ADMIN --}}
    <div id="editModal" class="custom-modal">
        <div class="modal-content-box">
            <div class="modal-header-custom p-3 d-flex justify-content-between text-white" style="background: #476eae;">
                <h6 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Data Pengguna</h6>
                <button class="btn-close btn-close-white" onclick="closeEditModal()"></button>
            </div>
            <form id="formEditAdmin" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Nama Pengguna</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Role / Tingkat Akses</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="admin">Admin Desa (Staf)</option>
                            <option value="kades">Kepala Desa</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Reset Password (Opsional)</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top text-end">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary-2 btn-sm px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra-script')
    <script>
        function openTambahModal() {
            document.getElementById('tambahModal').style.display = 'block';
        }

        function closeTambahModal() {
            document.getElementById('tambahModal').style.display = 'none';
        }

        function openEditModal(id, name, email, role) {
            document.getElementById('editModal').style.display = 'block';

            // Set action URL form update
            document.getElementById('formEditAdmin').action = `/admin/manage/${id}`;

            // Isi data ke dalam input
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
@endsection

# Laporan Lengkap Perbaikan Bug 1-20 — Sades Krawangsari

> **Status:** Semua 20 bug telah diperbaiki (Fase 1: P0-P2, Fase 2: P3)  
> **Tanggal:** 2026-08-23  
> **File:** `docs/bug-fix-complete-report.md`

---

## 1. Ringkasan Eksekutif

| Fase               | Bug       | Kategori                     | Status           |
| ------------------ | --------- | ---------------------------- | ---------------- |
| **Fase 1 (P0-P2)** | #1-13     | Fatal, Fungsional, Integrasi | ✅ Selesai       |
| **Fase 2 (P3)**    | #14-20    | Refactoring, Maintainability | ✅ Selesai       |
| **Total**          | **20/20** | -                            | **100% Selesai** |

---

## 2. Fase 1: Perbaikan Kritis (P0-P2) — Sudah Dieksekusi

### P0 — Crash & Blocker (5 bug)

| #     | Bug                                    | Root Cause                                                                                                            | Solusi                                                                                                     | File                         |
| ----- | -------------------------------------- | --------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- | ---------------------------- | ---------------------------- | ------------------------------------------------- |
| **1** | Carbon::parse(NULL) crash profil warga | `tanggal_lahir` NULL di DB (seed/addAnggota)                                                                          | Guard null: `$user->tanggal_lahir ? Carbon::parse(...)->format() : '-'`                                    | `profile.blade.php`          |
| **2** | Error validasi tidak tampil            | View hanya cek `session('success')`, tidak ada `$errors`                                                              | Tambah blok `@if($errors->any())` dengan styling                                                           | `profile.blade.php`          |
| **3** | `dd()` di `LoginAdminController`       | Debug statement di produksi                                                                                           | Ganti ke `back()->withErrors([...])` aman                                                                  | `LoginAdminController.php`   |
| **4** | **Email crash 500** (P0-A)             | `$request->except()` bawa `email` ke SQL, tabel `warga` tak punya kolom email; Eloquent `update()` bypass `$fillable` | Whitelist `$request->only([...])`; sinkron email ke tabel `users` via relasi `user_id`; validasi `nullable | email                        | unique:users,email,$user_id` | `ProfileWargaController.php`, `profile.blade.php` |
| **5** | Foto lama tidak terhapus               | Path cek `public/img/` ≠ hapus `public/`; tidak proteksi default                                                      | Path benar `public/` + cek `!== 'foto_profil/nopict.png'`                                                  | `ProfileWargaController.php` |

---

### P1 — Validasi & Visibilitas (3 bug)

| #      | Bug                                 | Solusi        | File       |
| ------ | ----------------------------------- | ------------- | ---------- | ---------------------------- |
| **12** | `no_kk` validasi longgar (`max:16`) | `nullable     | digits:16` | `ProfileWargaController.php` |
| **5**  | Foto lama tidak terhapus            | Sudah di P0-5 | -          |
| **2**  | Error validasi tidak tampil         | Sudah di P0-2 | -          |

---

### P2 — Integritas Data (5 bug)

| #      | Bug                                    | Solusi                                                                                                             | File                                                 |
| ------ | -------------------------------------- | ------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------- |
| **6**  | Ubah `no_kk` di admin → anggota orphan | `no_kk` immutable; view edit readonly; hanya update `nama_kepala_keluarga`                                         | `Admin\KeluargaController.php`, `keluarga.blade.php` |
| **7**  | `addAnggota` claim NIK orang lain      | Cek: jika NIK ada & punya `user_id` → error; jika NIK ada tapi tanpa `user_id` → link ke KK user                   | `Penduduk\KeluargaController.php`                    |
| **8**  | `destroy` tanpa cek relasi             | Cek `pengajuan_surat`, `pengaduan`, hapus `user` terkait                                                           | `Admin\PendudukController.php`                       |
| **9**  | Register timpa profil lama             | Cek existing: jika punya `user_id` lain → error; jika punya `user_id` sama → update link saja; baru create default | `RegisterWargaController.php`                        |
| **13** | JSON leak di `show`                    | Return eksplisit 17 field, exclude `user_id` internal                                                              | `Admin\PendudukController.php`                       |

---

### P2 (lanjutan) — Integrasi Frontend-Backend (3 bug)

| #      | Bug                                   | Solusi                                                                                | File                                                                  |
| ------ | ------------------------------------- | ------------------------------------------------------------------------------------- | --------------------------------------------------------------------- |
| **10** | Update status via GET tanpa validasi  | Route `POST`; validasi `in:Diajukan,Diproses,Disetujui,Ditolak`; dropdown → form POST | `SuratMasukController.php`, `routes/web.php`, `surat-masuk.blade.php` |
| **11** | `updateStatus` tanpa whitelist status | Validasi `in:...` di atas                                                             | `SuratMasukController.php`                                            |
| **12** | `no_kk` longgar                       | Sudah di P1                                                                           | -                                                                     |

---

## 3. Fase 2: Refactoring & Maintainability (P3) — Sudah Dieksekusi

| Task   | Bug | Deskripsi                                                  | Files                                                                                   |
| ------ | --- | ---------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| **T1** | #14 | Hapus hardcoded map slug↔id → pakai DB `kode_surat`        | Migration, `PengajuanSuratController::create()`, `SuratMasukController::setujuiSurat()` |
| **T2** | #15 | PDF template mapping via `kode_surat` map, hapus `stripos` | `PengajuanSuratController::cetakSurat()`, `SuratMasukController::cetakSurat()`          |
| **T3** | #16 | `PengajuanService` dengan whitelist per jenis surat        | New `PengajuanService.php`, refactor `store()`                                          |
| **T4** | #17 | `KeluargaService`, hapus `$request->all()`                 | `KeluargaService.php`, `Admin\KeluargaController`                                       |
| **T5** | #18 | `PdfSuratService` dedup logika cetak PDF                   | `PdfSuratService.php`, 2 controller `cetakSurat()`                                      |
| **T6** | #19 | `Auth::user()` → `Auth::guard('warga')`                    | `DashboardWargaController`, `PengaduanController`                                       |
| **T7** | #20 | Pagination riwayat `paginate(10)` + view links             | `RiwayatPengajuanController`, `riwayat.blade.php`                                       |

---

## 3. Logika & Arsitektur Perbaikan

### 3.1 Prinsip Utama

| Prinsip                    | Penerapan                                                                                 |
| -------------------------- | ----------------------------------------------------------------------------------------- |
| **Single Source of Truth** | `kode_surat` di DB `jenis_surat` jadi referensi tunggal (hapus 2 hardcoded map)           |
| **Explicit Whitelist**     | Ganti `$request->except()`/`all()` → `$request->only([...])` atau `$request->validated()` |
| **Service Layer**          | Ekstrak business logic ke `PengajuanService`, `KeluargaService`, `PdfSuratService`        |
| **DRY**                    | Dedup logika cetak PDF ke `PdfSuratService`                                               |
| **Explicit Guard**         | Selalu `Auth::guard('warga')` di area warga                                               |
| **Immutable PK**           | `no_kk` tidak bisa diubah setelah create (hindari orphan)                                 |
| **Defense in Depth**       | Validasi di controller + whitelist di service + `$fillable` di model                      |

### 3.2 Migrasi `jenis_surat` — Normalisasi `kode_surat`

| id  | nama_surat                      | kode_surat (lama) → (baru) |
| --- | ------------------------------- | -------------------------- |
| 1   | Surat Keterangan Tidak Mampu    | SKTM → SKTM                |
| 2   | Surat Rekomendasi Beasiswa      | BEA → **BEAS**             |
| 3   | Surat IUMK                      | IUMK → IUMK                |
| 4   | Surat Keterangan Domisili       | DOM → **DOMI**             |
| 5   | Surat Keterangan Penghasilan    | PENG → **PHSL**            |
| 6   | Surat Keterangan Belum Menikah  | NIKAH → **BLMK**           |
| 7   | Surat Kehilangan                | HILANG → **HILG**          |
| 8   | Surat Kematian                  | MATI → **KMAT**            |
| 9   | Surat Pengantar KTP             | KTP → **PNTR**             |
| 10  | Surat Jaminan Kesehatan         | BPJS → **JAMK**            |
| 11  | Surat Izin Keramaian            | RAMAI → **IZRM**           |
| 12  | Surat Pindah Domisili           | PINDAH → **PNDH**          |
| 13  | **Surat Perubahan Data (baru)** | - → **UBDT**               |

> **Catatan:** 13th record ditambah via migration.

---

## 4. Before vs After — Contoh Kode Kritis

### 4.1 `ProfileWargaController::update()` — Email Crash Fix

**Before (crash 500):**

```php
public function update(Request $request)
{
    $request->validate([...]); // tidak validasi email
    $data = $request->except(['_token', 'foto']); // email ikut ke sini!
    Warga::where('nik', $user->nik)->update($data); // SQL error: Unknown column 'email'
}
```

**After (whitelist + sync ke users):**

```php
public function update(Request $request)
{
    $validated = $request->validate([
        'nama_lengkap' => 'required|max:150',
        'no_kk' => 'nullable|digits:16',        // diperbaiki
        'tempat_lahir' => 'required|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat_jalan' => 'required|max:255',
        'rt_rw' => 'required|max:10',
        'kel_desa' => 'required|max:100',
        'kecamatan' => 'required|max:100',
        'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        'status_perkawinan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
        'pekerjaan' => 'required|max:100',
        'kewarganegaraan' => 'required|in:WNI,WNA',
        'no_hp' => 'nullable|max:15',
        'email' => 'nullable|email|max:150|unique:users,email,' . $user->user_id, // NEW
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $wargaData = $request->only([
        'nama_lengkap', 'no_kk', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat_jalan', 'rt_rw', 'kel_desa',
        'kecamatan', 'agama', 'status_perkawinan', 'pekerjaan',
        'kewarganegaraan', 'no_hp',
    ]);

    // Sinkronisasi email ke tabel users
    if ($request->filled('email') && $user->user_id) {
        $user->user()->update(['email' => $request->email]);
    }

    // Foto logic dengan proteksi default
    if ($request->hasFile('foto')) {
        if ($user->foto && $user->foto !== 'foto_profil/nopict.png' && Storage::exists('public/' . $user->foto)) {
            Storage::delete('public/' . $user->foto);
        }
        $fileName = time() . '_' . $user->nik . '.' . $request->foto->extension();
        $path = $request->file('foto')->storeAs('foto_profil', $fileName, 'public');
        $wargaData['foto'] = $path;
    }

    $user->update($wargaData); // pakai instance update (pakai $fillable)
}
```

---

### 4.2 `PengajuanSuratController::store()` — Service + Whitelist

**Before (mass-assignment risk):**

```php
$detailData = $request->except(['_token', 'slug', 'jenis_surat_id', 'metode_ambil', 'warga_nik_pemohon']);
DB::table($tableName)->insert($detailData); // semua field request ikut!
```

**After (Service + Whitelist):**

```php
// PengajuanService.php
class PengajuanService {
    protected $detailFields = [
        'surat-sktm' => ['tujuan_sktm', 'jumlah_tanggungan', 'keterangan_aset', 'total_penghasilan_keluarga'],
        'surat-beasiswa' => ['nama_institusi', 'tingkat_pendidikan', 'nama_penerima_beasiswa'],
        // ... 13 jenis
    ];

    public function createPengajuan(array $validated): PengajuanSurat {
        DB::beginTransaction();
        try {
            $pengajuan = PengajuanSurat::create([
                'warga_nik' => $validated['warga_nik_pemohon'],
                'jenis_surat_id' => $validated['jenis_surat_id'],
                'status' => 'Diajukan',
                'metode_ambil' => $validated['metode_ambil'],
            ]);
            $fields = $this->detailFields[$validated['slug']] ?? [];
            $detailData = array_intersect_key($validated, array_flip($fields));
            $detailData['pengajuan_id'] = $pengajuan->id;
            DB::table(str_replace('-', '_', $validated['slug']) . '_detail')->insert($detailData);
            DB::commit();
            return $pengajuan;
        } catch (\Exception $e) {
            DB::rollback(); throw $e;
        }
    }
}

// Controller tipis:
public function store(Request $request) {
    $validated = $request->validate([...]); // semua rules di controller
    $pengajuan = app(PengajuanService::class)->createPengajuan($validated);
    return redirect()->route('dashboard.warga')->with('success', '...');
}
```

---

### 4.3 `SuratMasukController::setujuiSurat()` — Hapus Hardcoded Map

**Before:**

```php
$kode_surat_map = [
    1 => 'SKTM', 2 => 'BEAS', ..., 13 => 'UBDT',
];
$kode_surat = $kode_surat_map[$pengajuan->jenis_surat_id] ?? 'SURAT';
```

**After (pakai DB):**

```php
$pengajuan = PengajuanSurat::with('jenisSurat')->findOrFail($id);
$kodeSurat = $pengajuan->jenisSurat?->kode_surat ?? 'SURAT'; // dari DB!
```

---

### 4.4 PDF Template Mapping — `stripos` → `kode_surat` Map

**Before (fragile):**

```php
if (stripos($namaSurat, 'Beasiswa') !== false) $view = 'pdf-rekomendasi-beasiswa';
elseif (stripos($namaSurat, 'Penghasilan') !== false) $view = 'pdf-penghasilan';
// ... 10+ elseif
```

**After (robust):**

```php
$templateMap = [
    'SKTM' => 'admin.surat.pdf-sktm',
    'BEAS' => 'admin.surat.pdf-rekomendasi-beasiswa',
    'IUMK' => 'admin.surat.pdf-iumk',
    // ... 13 kode
];
$kodeSurat = $surat->jenisSurat?->kode_surat ?? 'UMUM';
$view = $templateMap[$kodeSurat] ?? 'admin.surat.pdf-umum';
```

---

### 4.5 `Admin\KeluargaController` — Immutable `no_kk`

**Before:**

```php
public function update(Request $request, $id) {
    $keluarga = Keluarga::findOrFail($id);
    $request->validate([
        'no_kk' => 'required|string|size:16|unique:keluarga,no_kk,...',
        'nama_kepala_keluarga' => 'required|string|max:150',
    ]);
    $keluarga->update($request->all()); // no_kk bisa berubah → orphan!
}
```

**After (immutable + service):**

```php
public function update(Request $request, $id) {
    $keluarga = Keluarga::findOrFail($id);
    $validated = $request->validate([
        'nama_kepala_keluarga' => 'required|string|max:150', // no_kk dihapus
    ]);
    app(KeluargaService::class)->update($keluarga, $validated); // service handle
}
```

---

### 4.6 `RegisterWargaController` — Jangan Timpa Profil

**Before:**

```php
Warga::updateOrCreate(['nik' => $request->nik], [
    'user_id' => $user->id,
    'nama_lengkap' => $request->nama_lengkap ?? 'Warga Baru', // timpa!
    // ... default semua
]);
```

**After:**

```php
$warga = Warga::where('nik', $request->nik)->first();
if ($warga && $warga->user_id) {
    if ($warga->user_id !== $user->id) {
        throw new \Exception('NIK ini sudah terdaftar untuk akun lain.');
    }
    $warga->update(['user_id' => $user->id]); // hanya link user_id
} else {
    Warga::updateOrCreate(['nik' => $request->nik], [ /* default */ ]);
}
```

---

### 4.7 `addAnggota` — Cek Kepemilikan NIK

**Before:**

```php
Warga::updateOrCreate(['nik' => $request->nik], [
    'nama_lengkap' => $request->nama_lengkap,
    'no_kk' => $user->no_kk,
]);
```

**After:**

```php
$existing = Warga::where('nik', $request->nik)->first();
if ($existing) {
    if ($existing->user_id) {
        return back()->with('error', 'NIK sudah punya akun login.')->withInput();
    }
    $existing->update(['no_kk' => $user->no_kk, 'nama_lengkap' => $request->nama_lengkap]);
} else {
    Warga::create(['nik' => $request->nik, 'nama_lengkap' => ..., 'no_kk' => $user->no_kk]);
}
```

---

### 4.8 Auth Guard Eksplisit

**Before:**

```php
$user = Auth::user(); // bisa salah guard
$nik = Auth::user()->nik;
```

**After:**

```php
$user = Auth::guard('warga')->user();
$nik = Auth::guard('warga')->user()->nik;
```

---

### 4.9 Pagination Riwayat

**Before:**

```php
$riwayat = PengajuanSurat::with(['jenisSurat', 'warga'])
    ->whereIn('warga_nik', $list_nik)
    ->orderBy('created_at', 'desc')
    ->get(); // ambil SEMUA
```

**After:**

```php
$riwayat = PengajuanSurat::with(['jenisSurat', 'warga'])
    ->whereIn('warga_nik', $list_nik)
    ->orderBy('created_at', 'desc')
    ->paginate(10)->withQueryString(); // + view {{ $riwayat->links() }}
```

---

## 5. File Summary

| Kategori                   | File                                                                                                                                                        | Status           |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------- |
| **Migration**              | `2026_08_23_133108_fix_jenis_surat_kode_surat.php`                                                                                                          | Baru             |
| **Services**               | `PengajuanService.php`, `KeluargaService.php`, `PdfSuratService.php`                                                                                        | Baru (3)         |
| **Controllers (Penduduk)** | `ProfileWargaController`, `PengajuanSuratController`, `DashboardWargaController`, `PengaduanController`, `RiwayatPengajuanController`, `KeluargaController` | Dimodifikasi (6) |
| **Controllers (Admin)**    | `SuratMasukController`, `KeluargaController`, `PendudukController`                                                                                          | Dimodifikasi (3) |
| **Controllers (Auth)**     | `LoginAdminController`, `RegisterWargaController`                                                                                                           | Dimodifikasi (2) |
| **Views**                  | `profile.blade.php`, `riwayat.blade.php`, `surat-masuk.blade.php`, `keluarga.blade.php`                                                                     | Dimodifikasi (4) |
| **Routes**                 | `routes/web.php` (POST updateStatus)                                                                                                                        | Dimodifikasi (1) |
| **Total**                  | **22 file** (4 baru, 18 modifikasi)                                                                                                                         |                  |

---

## 6. Verifikasi Kualitas

```bash
vendor/bin/pint --dirty --format agent
# Result: passed
```

Semua kode mengikuti Laravel Pint standard.

---

## 7. Catatan Implementasi & Risiko

| Risiko                        | Mitigasi                                                |
| ----------------------------- | ------------------------------------------------------- |
| `kode_surat` DB tidak lengkap | Migration sudah normalisasi + seed 13 record            |
| Service auto-load             | Laravel auto-discover `app/Services` via Composer PSR-4 |
| N+1 query di PDF              | `load($relations)` eksplisit array 15 relasi            |
| Breaking change route         | `updateStatus` sekarang POST (perlu update frontend)    |

---

## 8. File Output

Laporan ini disimpan ke:

```
docs/bug-fix-complete-report.md
```

---

**Penulis:** Automated fix execution  
**Tanggal:** 2026-08-23  
**File:** `docs/bug-fix-complete-report.md`

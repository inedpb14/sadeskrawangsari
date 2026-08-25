# Laporan Analisa Error — Sades Krawangsari

> Ringkasan poin-poin masalah pada aplikasi, dikelompokkan berdasarkan tingkat keparahan.

---

## 🔴 Error Fatal (Kritis)

1. **500 error saat buka halaman profil warga** — `Carbon::parse($user->tanggal_lahir)` dipanggil tanpa guard di `warga/profile.blade.php:52`; warga dengan `tanggal_lahir NULL` (data dari `addAnggota`/seed) → halaman tidak bisa dibuka.
2. **Pesan error validasi tidak pernah muncul** — `profile.blade.php` hanya menampilkan `session('success')`, tanpa blok `$errors->any()` → user submit gagal tanpa keterangan.
3. **`dd()` di `LoginAdminController`** — masih ada `dd('Akar masalah: ...')` (baris 26, 30) → fatal di produksi, bocor info debug.

---

## 🟠 Error Fungsional (Logika)

4. **Field `email` di form profil mati** — form punya input email, tapi tabel `warga` tidak punya kolom email & backend tidak memvalidasi → data selalu hilang.
5. **Foto lama tidak terhapus** — path cek salah (`public/img/...`) ≠ path hapus (`public/...`) di `ProfileWargaController:48-49` → file menumpuk di storage.
6. **Ubah `no_kk` di admin keluarga → anggota warga ter-orphan** — `warga.no_kk` tidak ikut di-update; relasi putus tanpa error.
7. **`addAnggota` bisa claim NIK orang lain** — `Warga::updateOrCreate(['nik' => ...])` tanpa cek kepemilikan → manipulasi data keluarga.
8. **`PendudukController::destroy` tanpa cek relasi** — hapus warga yang punya pengajuan/pengaduan → history rusak; akun `users` juga jadi yatim.
9. **`RegisterWargaController` menimpa profil lama** — `updateOrCreate` dengan nilai default (`'Warga Baru'`, `'Indonesia'`) saat NIK sudah terdaftar.

---

## 🟡 Error Integrasi Frontend-Backend

10. **Status surat diubah via GET** — route `admin.surat-proses/{id}/{status}` tanpa validasi, tidak idempoten.
11. **`updateStatus` tanpa validasi `in:`** — status bebas apa pun bisa tersimpan.
12. **Validasi `no_kk` longgar** — hanya `nullable|max:16` di profil (bukan `digits:16`); `jenis_kelamin` NULL tampil "Perempuan".
13. **JSON `show` surat/penduduk bocor field internal** — mengembalikan seluruh record (termasuk `user_id`, `is_active`).

---

## ⚠️ Risiko & Desain Rentan

14. **Map hardcoded slug↔id di 2 tempat** (`create()` & `setujuiSurat()`) — tambah jenis surat wajib edit 2+ file.
15. **Mapping template PDF via `stripos` nama surat** — nama berubah sedikit → salah template.
16. **`store()` pengajuan menyimpan semua field request** — tanpa whitelist → mass-assignment.
17. **`update($request->all())`** di `Admin\KeluargaController` — tidak eksplisit (aman karena `$fillable`, tapi rapuh).
18. **Duplikasi logika cetak PDF** (warga & admin) — 2 tempat, mudah tak sinkron.
19. **`Auth::user()` tanpa guard eksplisit** di beberapa controller warga (`DashboardWargaController:16`, `PengaduanController:14`) — rentan salah guard.
20. **Tidak ada pagination** di riwayat pengajuan warga → beban query meningkat.

---

## ✅ Yang Sudah Benar

- Guard eksplisit `Auth::guard('warga')` di controller profil & login
- `@csrf` + `@method` benar di semua form
- Validasi file foto (`image|mimes|max:2048`) & export Excel dengan NIK tetap string
- Transaksi `DB::beginTransaction` pada register & pengajuan surat

---

**Ringkasan:** 3 error fatal, 6 error fungsional, 3 integrasi gagal, 8 risiko desain.

**Prioritas perbaikan:** #1–3 → #4–6 → #7–9 → sisanya.
<div class="form-group full-width">
    <label>Jenis Dokumen yang Diurus</label>
    <select name="jenis_pengantar" required>
        <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
        <option value="Pembuatan KTP Baru">Pembuatan KTP Baru</option>
        <option value="Perubahan Data KTP">Perubahan Data KTP</option>
        <option value="Pembuatan KK Baru (Pecah KK / Menikah)">Pembuatan KK Baru (Pecah KK / Menikah)</option>
        <option value="Perubahan Data KK">Perubahan Data KK</option>
        <option value="Pembuatan Akta Kelahiran">Pembuatan Akta Kelahiran</option>
        <option value="Pembuatan Akta Kematian">Pembuatan Akta Kematian</option>
        <option value="Lainnya">Lainnya...</option>
    </select>
</div>

<div class="form-group full-width">
    <label>Keterangan / Alasan Permohonan</label>
    <textarea name="keterangan" class="custom-textarea"
        placeholder="Contoh: Pembuatan KTP karena baru berusia 17 Tahun, atau Perubahan KK karena penambahan anggota keluarga baru (anak lahir)..."
        required></textarea>
</div>

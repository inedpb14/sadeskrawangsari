<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'nomor_surat',
        'warga_nik',
        'jenis_surat_id',
        'status',
        'metode_ambil',
        'keterangan_admin',
        'final_path_pdf',
        'kode_verifikasi_qr',
    ];

    // --- Relasi Utama ---

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_nik', 'nik');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id', 'id');
    }

    // --- Relasi ke Detail Surat (Satu per Satu) ---

    public function beasiswaDetail()
    {
        return $this->hasOne(SuratBeasiswaDetail::class, 'pengajuan_id', 'id');
    }

    public function belumMenikahDetail()
    {
        return $this->hasOne(SuratBelumMenikahDetail::class, 'pengajuan_id', 'id');
    }

    public function domisiliDetail()
    {
        return $this->hasOne(SuratDomisiliDetail::class, 'pengajuan_id', 'id');
    }

    public function iumkDetail()
    {
        return $this->hasOne(SuratIumkDetail::class, 'pengajuan_id', 'id');
    }

    public function izinKeramaianDetail()
    {
        return $this->hasOne(SuratIzinKeramaianDetail::class, 'pengajuan_id', 'id');
    }

    public function jaminanKesehatanDetail()
    {
        return $this->hasOne(SuratJaminanKesehatanDetail::class, 'pengajuan_id', 'id');
    }

    public function kehilanganDokDetail()
    {
        return $this->hasOne(SuratKehilanganDokDetail::class, 'pengajuan_id', 'id');
    }

    public function kematianDetail()
    {
        return $this->hasOne(SuratKematianDetail::class, 'pengajuan_id', 'id');
    }

    public function pengantarKtpDetail()
    {
        return $this->hasOne(SuratPengantarKtpDetail::class, 'pengajuan_id', 'id');
    }

    public function pengantarDetail()
    {
        return $this->hasOne(SuratPengantarDetail::class, 'pengajuan_id', 'id');
    }

    public function penghasilanDetail()
    {
        return $this->hasOne(SuratPenghasilanDetail::class, 'pengajuan_id', 'id');
    }

    public function perubahanDataDetail()
    {
        return $this->hasOne(SuratPerubahanDataDetail::class, 'pengajuan_id', 'id');
    }

    public function pindahDetail()
    {
        return $this->hasOne(SuratPindahDomisiliDetail::class, 'pengajuan_id', 'id');
    }

    public function sktmDetail()
    {
        return $this->hasOne(SuratSktmDetail::class, 'pengajuan_id', 'id');
    }
}

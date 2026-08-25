<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratIzinKeramaianDetail extends Model
{
    protected $table = 'surat_keramaian_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'nama_kegiatan', 'lokasi_kegiatan', 'tgl_mulai', 'tgl_selesai', 'penanggung_jawab'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

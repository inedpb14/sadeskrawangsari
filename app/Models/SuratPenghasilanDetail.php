<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPenghasilanDetail extends Model
{
    protected $table = 'surat_penghasilan_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'penghasilan_per_bulan', 'pekerjaan_sebenarnya', 'tempat_kerja', 'tujuan_surat'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

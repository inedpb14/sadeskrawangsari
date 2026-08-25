<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratSktmDetail extends Model
{
    protected $table = 'surat_sktm_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = [
        'pengajuan_id',
        'tujuan_sktm',
        'jumlah_tanggungan',
        'keterangan_aset',
        'total_penghasilan_keluarga',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

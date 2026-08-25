<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPerubahanDataDetail extends Model
{
    protected $table = 'surat_perubahan_data_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'data_lama', 'data_baru', 'alasan_perubahan'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJaminanKesehatanDetail extends Model
{
    protected $table = 'surat_jamkes_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'status_peserta', 'program_bantuan', 'nik_tertanggung'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

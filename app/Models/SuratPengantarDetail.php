<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantarDetail extends Model
{
    protected $table = 'surat_pengantar_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'jenis_pengantar', 'keterangan'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

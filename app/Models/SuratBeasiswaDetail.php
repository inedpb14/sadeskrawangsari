<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBeasiswaDetail extends Model
{
    protected $table = 'surat_beasiswa_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'nama_institusi', 'tingkat_pendidikan', 'nama_penerima_beasiswa'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

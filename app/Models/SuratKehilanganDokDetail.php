<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKehilanganDokDetail extends Model
{
    protected $table = 'surat_kehilangan_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'jenis_dokumen_hilang', 'keterangan_hilang', 'lokasi_hilang'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}

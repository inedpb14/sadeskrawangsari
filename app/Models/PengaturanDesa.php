<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanDesa extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (karena Laravel otomatis akan mencari tabel 'pengaturan_desas' jika tidak didefinisikan)
    protected $table = 'pengaturan_desa';

    // Mengizinkan kolom-kolom ini untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'nama_desa',
        'alamat',
        'telepon',
        'email',
        'visi_misi',
        'sejarah',
        'sambutan_kades',
        'nama_kades',
        'foto_kades',
        'hero_image',
    ];
}

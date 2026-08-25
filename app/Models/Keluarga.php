<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';

    protected $primaryKey = 'no_kk'; // Primary key menggunakan no_kk

    public $incrementing = false; // Karena no_kk bukan auto-increment

    protected $keyType = 'string';

    protected $fillable = ['no_kk', 'nama_kepala_keluarga'];

    // Relasi: Satu KK memiliki banyak Anggota (Warga)
    public function anggota()
    {
        return $this->hasMany(Warga::class, 'no_kk', 'no_kk');
    }
}

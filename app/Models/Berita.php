<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika nama tabel sudah 'beritas')
    protected $table = 'berita';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'status',
        'admin_id',
    ];

    /**
     * Relasi ke Admin: Setiap berita ditulis oleh seorang admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

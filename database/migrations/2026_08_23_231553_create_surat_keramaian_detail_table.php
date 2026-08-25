<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keramaian_detail', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_kegiatan', 255);
            $table->text('lokasi_kegiatan');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->string('penanggung_jawab', 150);
            $table->timestamps();

            $table->primary('pengajuan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keramaian_detail');
    }
};

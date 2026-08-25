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
        Schema::create('surat_kematian_detail', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nik_yang_meninggal', 16);
            $table->string('nama_yang_meninggal', 150);
            $table->dateTime('tanggal_kematian');
            $table->string('tempat_kematian', 100);
            $table->text('penyebab_kematian');
            $table->string('nik_pelapor', 16);
            $table->timestamps();

            $table->primary('pengajuan_id');
            $table->foreign('nik_pelapor')->references('nik')->on('warga')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_kematian_detail');
    }
};

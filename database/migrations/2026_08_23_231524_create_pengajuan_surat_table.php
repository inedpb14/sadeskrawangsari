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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 255)->nullable();
            $table->string('warga_nik', 16);
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onUpdate('cascade');
            $table->enum('status', ['Diajukan', 'Diproses', 'Disetujui', 'Ditolak'])->default('Diajukan');
            $table->enum('metode_ambil', ['kantor', 'mandiri']);
            $table->text('keterangan_admin')->nullable();
            $table->string('final_pdf_path', 255)->nullable();
            $table->string('kode_verifikasi_qr', 50)->nullable()->unique();
            $table->timestamps();

            $table->foreign('warga_nik')->references('nik')->on('warga')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};

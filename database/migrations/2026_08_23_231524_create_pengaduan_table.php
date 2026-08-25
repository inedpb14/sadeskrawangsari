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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('warga_nik', 16);
            $table->string('kategori', 100);
            $table->string('judul', 255);
            $table->text('isi_pengaduan');
            $table->string('lampiran_path', 255)->nullable();
            $table->enum('status', ['Baru', 'Diterima', 'Diproses', 'Selesai', 'Ditolak'])->default('Baru');
            $table->text('tanggapan_admin')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admin')->nullOnDelete();
            $table->timestamps();

            $table->foreign('warga_nik')->references('nik')->on('warga')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};

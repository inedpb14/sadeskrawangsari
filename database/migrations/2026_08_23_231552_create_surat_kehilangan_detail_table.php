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
        Schema::create('surat_kehilangan_detail', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jenis_dokumen_hilang', 100);
            $table->text('keterangan_hilang');
            $table->string('lokasi_hilang', 255);
            $table->timestamps();

            $table->primary('pengajuan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_kehilangan_detail');
    }
};

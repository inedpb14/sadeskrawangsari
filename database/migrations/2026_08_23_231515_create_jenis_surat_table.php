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
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat', 10)->unique();
            $table->string('nama_surat', 150);
            $table->string('kategori', 50);
            $table->string('template_file_path', 255)->nullable();
            $table->enum('opsi_pengambilan', ['kantor', 'mandiri', 'keduanya'])->default('keduanya');
            $table->text('deskripsi_form')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};

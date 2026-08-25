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
        Schema::create('warga', function (Blueprint $table) {
            $table->string('nik', 16)->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap', 150);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('alamat_jalan', 255)->nullable();
            $table->string('rt_rw', 10)->nullable();
            $table->string('kel_desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->enum('status_perkawinan', ['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'])->default('Belum Kawin');
            $table->string('pekerjaan', 100)->nullable();
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI');
            $table->string('no_hp', 15)->nullable();
            $table->string('foto', 255)->default('foto_profil/nopict.png');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('no_kk')->references('no_kk')->on('keluarga')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};

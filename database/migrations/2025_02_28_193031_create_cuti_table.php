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
        Schema::create('cuti', function (Blueprint $table) {
            $table->id('id_cuti');
            $table->unsignedBigInteger('karyawan_id');
            $table->unsignedBigInteger('jenis_cuti')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->string('alasan', 255);

            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
            $table->foreign('jenis_cuti')->references('id_jenis_cuti')->on('jenis_cuti')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};

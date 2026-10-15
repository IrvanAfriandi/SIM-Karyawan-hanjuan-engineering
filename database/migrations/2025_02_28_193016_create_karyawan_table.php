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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->unsignedBigInteger('karyawan_users');
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->bigInteger('nik');
            $table->date('tgl_masuk');
            $table->string('foto', 255);

            $table->foreign('karyawan_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id_jabatan')->on('jabatan')->onDelete('set null');
            $table->foreign('divisi_id')->references('id_divisi')->on('divisi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};

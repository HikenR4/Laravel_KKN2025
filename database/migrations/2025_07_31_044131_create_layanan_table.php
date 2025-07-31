<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_layanan', 20)->unique()->nullable();
            $table->string('nama_layanan', 200);
            $table->string('slug', 250)->unique();
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->text('prosedur')->nullable();
            $table->string('biaya', 50)->nullable();
            $table->string('waktu_penyelesaian', 50)->nullable();
            $table->text('dasar_hukum')->nullable();
            $table->string('output_layanan', 200)->nullable();
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('kontak', 50)->nullable();
            $table->string('formulir_url')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan');
    }
};
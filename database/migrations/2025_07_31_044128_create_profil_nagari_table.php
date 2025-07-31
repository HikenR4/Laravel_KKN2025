<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_nagari', function (Blueprint $table) {
            $table->id();
            $table->string('nama_nagari', 100);
            $table->string('kode_nagari', 20)->nullable();
            $table->text('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->decimal('koordinat_lat', 10, 7)->nullable();
            $table->decimal('koordinat_lng', 10, 7)->nullable();
            $table->string('luas_wilayah', 50)->nullable();
            $table->text('batas_utara')->nullable();
            $table->text('batas_selatan')->nullable();
            $table->text('batas_timur')->nullable();
            $table->text('batas_barat')->nullable();
            $table->integer('jumlah_rt')->default(0);
            $table->integer('jumlah_rw')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_nagari');
    }
};
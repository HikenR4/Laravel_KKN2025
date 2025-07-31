<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 250)->unique();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('lokasi', 200)->nullable();
            $table->decimal('koordinat_lat', 10, 7)->nullable();
            $table->decimal('koordinat_lng', 10, 7)->nullable();
            $table->string('gambar')->nullable();
            $table->string('alt_gambar')->nullable();
            $table->string('kategori', 50)->default('lainnya');
            $table->string('status', 20)->default('planned');
            $table->integer('peserta_target')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('kontak_person', 20)->nullable();
            $table->foreignId('admin_id')->constrained('admin')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
};

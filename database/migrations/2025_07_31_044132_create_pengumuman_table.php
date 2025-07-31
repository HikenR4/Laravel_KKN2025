<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 250)->unique();
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_berakhir')->nullable();
            $table->boolean('penting')->default(false);
            $table->string('kategori', 50)->default('umum');
            $table->string('target_audience', 50)->default('semua');
            $table->string('status', 20)->default('aktif');
            $table->integer('views')->default(0);
            $table->foreignId('admin_id')->constrained('admin')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
};
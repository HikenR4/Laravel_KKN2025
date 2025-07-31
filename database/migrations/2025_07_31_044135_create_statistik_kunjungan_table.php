<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('statistik_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('halaman');
            $table->integer('jumlah_kunjungan')->default(1);
            $table->integer('unique_visitors')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('statistik_kunjungan');
    }
};
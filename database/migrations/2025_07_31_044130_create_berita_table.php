<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 250)->unique();
            $table->text('konten');
            $table->text('excerpt')->nullable();
            $table->string('gambar')->nullable();
            $table->string('alt_gambar')->nullable();
            $table->date('tanggal');
            $table->integer('views')->default(0);
            $table->string('status', 20)->default('published');
            $table->boolean('featured')->default(false);
            $table->string('kategori', 50)->default('umum');
            $table->string('tags')->nullable();
            $table->text('meta_description')->nullable();
            $table->foreignId('admin_id')->constrained('admin')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};
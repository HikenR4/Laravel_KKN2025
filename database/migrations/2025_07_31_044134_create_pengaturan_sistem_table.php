<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('key_setting', 100)->unique();
            $table->text('value_setting')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kategori', 50)->default('umum');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan_sistem');
    }
};

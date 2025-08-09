<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perangkat_nagari', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('jabatan', 100);
            $table->string('nip', 50)->nullable()->unique();
            $table->string('foto')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->date('masa_jabatan_mulai')->nullable();
            $table->date('masa_jabatan_selesai')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('urutan');
            $table->index(['status', 'urutan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_nagari');
    }
};

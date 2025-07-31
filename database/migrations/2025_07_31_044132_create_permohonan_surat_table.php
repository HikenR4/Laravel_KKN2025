<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan', 50)->unique();
            $table->string('nama_pemohon', 100);
            $table->string('nik', 16);
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('jenis_surat', 100);
            $table->text('keperluan')->nullable();
            $table->text('dokumen_pendukung')->nullable();
            $table->date('tanggal_permohonan');
            $table->date('tanggal_estimasi_selesai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('keterangan')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->decimal('biaya', 10, 2)->default(0);
            $table->foreignId('admin_processor')->nullable()->constrained('admin')->onDelete('set null');
            $table->string('nomor_surat', 100)->nullable();
            $table->string('file_surat')->nullable();
            
            // Foreign key to data_penduduk
            $table->foreign('nik')->references('nik')->on('data_penduduk')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_surat');
    }
};
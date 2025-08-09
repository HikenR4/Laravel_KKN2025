<?php
// File: database/migrations/2025_08_09_add_video_to_profil_nagari_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profil_nagari', function (Blueprint $table) {
            $table->string('video_profil')->nullable()->after('banner');
            $table->string('video_url')->nullable()->after('video_profil'); // untuk video eksternal (YouTube, dll)
            $table->text('video_deskripsi')->nullable()->after('video_url');
            $table->integer('video_durasi')->nullable()->after('video_deskripsi'); // dalam detik
            $table->decimal('video_size', 8, 2)->nullable()->after('video_durasi'); // dalam MB
        });
    }

    public function down()
    {
        Schema::table('profil_nagari', function (Blueprint $table) {
            $table->dropColumn([
                'video_profil',
                'video_url',
                'video_deskripsi',
                'video_durasi',
                'video_size'
            ]);
        });
    }
};

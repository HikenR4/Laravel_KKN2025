<?php
// File: database/migrations/2025_08_15_000001_add_video_fields_to_profil_nagari_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profil_nagari', function (Blueprint $table) {
            // Add video fields if they don't exist
            if (!Schema::hasColumn('profil_nagari', 'video_profil')) {
                $table->string('video_profil')->nullable()->after('banner');
            }
            if (!Schema::hasColumn('profil_nagari', 'video_url')) {
                $table->string('video_url')->nullable()->after('video_profil');
            }
            if (!Schema::hasColumn('profil_nagari', 'video_deskripsi')) {
                $table->text('video_deskripsi')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('profil_nagari', 'video_durasi')) {
                $table->integer('video_durasi')->nullable()->after('video_deskripsi');
            }
            if (!Schema::hasColumn('profil_nagari', 'video_size')) {
                $table->decimal('video_size', 8, 2)->nullable()->after('video_durasi');
            }
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
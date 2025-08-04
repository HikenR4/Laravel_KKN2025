<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->string('password', 255)->change();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->change();
            $table->softDeletes();
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('role', 20)->default('admin')->after('foto');
            $table->string('password')->change();
            $table->string('status', 20)->default('aktif')->change();
            $table->dropSoftDeletes();
            $table->dropIndex(['status']);
        });
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // PERBAIKAN: Gunakan DB transaction untuk keamanan
        DB::transaction(function () {

            // Admin utama
            Admin::updateOrCreate(
                ['username' => 'MungoAdmin'],
                [
                    'password' => env('ADMIN_PASSWORD', 'M-unGo-o0'), // Akan di-hash oleh mutator
                    'nama_lengkap' => 'Administrator Nagari Mungo',
                    'email' => 'admin@nagarimungo.id',
                    'status' => 'aktif',
                    'login_attempts' => 0,
                    'locked_until' => null,
                ]
            );

            // PERBAIKAN: Tambahkan admin default untuk backup
            Admin::updateOrCreate(
                ['username' => 'admin'],
                [
                    'password' => 'admin123', // Akan di-hash oleh mutator
                    'nama_lengkap' => 'Administrator',
                    'email' => 'admin@mungo.go.id',
                    'status' => 'aktif',
                    'login_attempts' => 0,
                    'locked_until' => null,
                ]
            );

            // PERBAIKAN: Tambahkan admin untuk wali nagari
            Admin::updateOrCreate(
                ['username' => 'walinagari'],
                [
                    'password' => 'wali123', // Akan di-hash oleh mutator
                    'nama_lengkap' => 'Wali Nagari',
                    'email' => 'walinagari@nagarimungo.id',
                    'status' => 'aktif',
                    'login_attempts' => 0,
                    'locked_until' => null,
                ]
            );

            echo "✅ Admin seeder completed successfully!\n";
            echo "👤 Login credentials:\n";
            echo "   Username: MungoAdmin | Password: " . env('ADMIN_PASSWORD', 'M-unGo-o0') . "\n";
            echo "   Username: admin      | Password: admin123\n";
            echo "   Username: walinagari | Password: wali123\n";
        });
    }
}

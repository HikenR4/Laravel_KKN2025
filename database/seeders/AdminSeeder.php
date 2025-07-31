<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        Admin::create([
            'username' => 'superadmin',
            'password' => 'mungo123', 
            'nama_lengkap' => 'Super Administrator',
            'email' => 'superadmin@nagarimungo.id',
            'role' => 'superadmin',
            'status' => 'aktif',
        ]);

        // Admin Utama
        Admin::create([
            'username' => 'admin',
            'password' => 'admin123',
            'nama_lengkap' => 'Administrator Nagari Mungo',
            'email' => 'admin@nagarimungo.id',
            'role' => 'admin',
            'status' => 'aktif',
        ]);
    }
}
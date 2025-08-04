<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['username' => 'MungoAdmin'],
            [
                'password' => Hash::make(env('ADMIN_PASSWORD', 'M-unGo-o0')),
                'nama_lengkap' => 'Administrator Nagari Mungo',
                'email' => 'admin@nagarimungo.id',
                'status' => 'aktif',
            ]
        );
    }
}

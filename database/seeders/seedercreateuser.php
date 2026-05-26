<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class seedercreateuser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin:akses penuh crud master lowongan,seleksi pendaftaran magang/approval,dan semua laporan
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // guest:melihat lowongan dan create pendaftaran magang
        User::updateOrCreate(
            ['email' => 'guest@test.com'],
            [
                'name' => 'Guest User',
                'password' => Hash::make('password'),
                'role' => 'guest',
            ]
        );
    }
}

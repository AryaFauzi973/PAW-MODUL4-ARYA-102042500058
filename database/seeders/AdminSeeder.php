<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@telkomlibrary.ac.id')->exists()) {
            User::create([
                'name'              => 'Admin Perpustakaan',
                'email'             => 'admin@telkomlibrary.ac.id',
                'password'          => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role'              => 'admin',
            ]);
        }

        if (!User::where('email', 'mahasiswa@telkomlibrary.ac.id')->exists()) {
            User::create([
                'name'              => 'Rio Mahasiswa',
                'email'             => 'mahasiswa@telkomlibrary.ac.id',
                'password'          => Hash::make('mahasiswa123'),
                'email_verified_at' => now(),
                'role'              => 'mahasiswa',
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Guru',
            'username' => 'guru',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        User::create([
            'nama' => 'Siswa',
            'username' => 'siswa',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Guru SMK',
            'username' => 'guru',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        User::create([
            'nama' => 'Siswa SMK',
            'username' => 'siswa',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        // Create Categories
        $categories = [
            'Teknologi',
            'Pendidikan',
            'Olahraga',
            'Seni & Budaya',
            'Berita Sekolah',
            'Tips & Tutorial'
        ];

        foreach ($categories as $category) {
            Kategori::create([
                'nama_kategori' => $category
            ]);
        }
    }
}
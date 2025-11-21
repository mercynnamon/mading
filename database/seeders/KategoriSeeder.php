<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            'Berita',
            'Olahraga', 
            'Pendidikan',
            'Teknologi',
            'Seni & Budaya'
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['nama_kategori' => $kategori]);
        }
    }
}
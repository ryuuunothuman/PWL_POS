<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $kategoriNames = ['Cemilan', 'Makanan Ringan'];
        $kategoriKodes = ['CML', 'MNR'];
        for ($i = 0; $i < 2; $i++) {
            $data[] = [
                'kategori_kode' => $kategoriKodes[$i],
                'kategori_nama' => $kategoriNames[$i],
                'created_at' => now(),
            ];
        }
        DB::table('m_kategori')->insert($data);
    }
}
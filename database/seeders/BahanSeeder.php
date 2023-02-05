<?php

namespace Database\Seeders;

use App\Models\DataBahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // buat 20 bahan jadi dari awal
        for ($i = 1; $i <= 20; $i++) {
            DataBahan::create(
                [
                    'kd_bahan' => 'BNH00' . $i,
                    'nm_bahan' => 'Bahan ' . $i,
                    'harga_beli' => 10000,
                    'stok' => 100,
                    'ket' => 'Bahan Enak',
                ]
            );
        }
    }
}

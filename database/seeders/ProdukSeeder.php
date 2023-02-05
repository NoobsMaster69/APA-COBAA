<?php

namespace Database\Seeders;

use App\Models\ProdukJadi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // buat 20 produk jadi dari awal dan nm_produknya harus bervariasi contohnya roti abon, roti coklat, dll sampai 20
        
        for ($i = 1; $i <= 20; $i++) {
            ProdukJadi::create(
                [
                    'kd_produk' => 'PRDK00' . $i,
                    'nm_produk' => 'Roti ' . $i,
                    'stok' => 0,
                    'modal' => 0,
                    'harga_jual' => 0,
                    'berat' => 0.05,
                    'ket' => 'Roti Enak',
                    'foto' => 'roti_' . $i . '.jpg',
                ]
            );
        }
    }
}

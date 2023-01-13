<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Satuan::create([
            'nm_satuan' => 'pcs',
        ]);

        Satuan::create([
            'nm_satuan' => 'Kg',
        ]);

        Satuan::create([
            'nm_satuan' => 'liter',
        ]);

        Satuan::create([
            'nm_satuan' => 'gram',
        ]);

        Satuan::create([
            'nm_satuan' => 'mililiter',
        ]);
    }
}

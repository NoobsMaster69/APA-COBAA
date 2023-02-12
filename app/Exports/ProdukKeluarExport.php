<?php

namespace App\Exports;

use App\Models\ProdukKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukKeluarExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ProdukKeluar::join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
            ->select('produkJadi.nm_produk', 'produkKeluar.jumlah', 'produkKeluar.tgl_keluar', 'produkKeluar.harga_jual', 'produkKeluar.total')->get();
    }

    public function headings(): array
    {
        return ['NAMA PRODUK', 'JUMLAH', 'TANGGAL PENJUALAN', 'HARGA JUAL', 'TOTAL'];
    }
}

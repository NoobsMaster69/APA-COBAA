<?php

namespace App\Exports;

use App\Models\ProdukMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukMasukExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return produkMasuk::join('produkJadi', 'produkMasuk.kd_produk', '=', 'produkJadi.kd_produk')->select('produkJadi.nm_produk', 'produkMasuk.tgl_produksi', 'produkMasuk.tgl_expired', 'produkMasuk.jumlah', 'produkJadi.modal', 'produkMasuk.total')->get();
    }

    public function headings(): array
    {
        return ['NAMA PRODUK', 'TANGGAL PRODUKSI', 'TANGGAL KADALUWARSA', 'JUMLAH', 'MODAL', 'TOTAL'];
    }
}

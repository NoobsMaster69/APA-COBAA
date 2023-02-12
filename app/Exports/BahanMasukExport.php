<?php

namespace App\Exports;

use App\Models\BahanMasuk;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BahanMasukExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BahanMasuk::join('dataBahan', 'bahanMasuk.kd_bahan', '=', 'dataBahan.kd_bahan')->select('bahanMasuk.id_bahanMasuk', 'bahanMasuk.kd_bahan', 'dataBahan.nm_bahan', 'bahanMasuk.tgl_masuk', 'dataBahan.harga_beli', 'bahanMasuk.jumlah', 'bahanMasuk.total')->get();
    }

    public function headings(): array
    {
        return ['ID', 'KODE BAHAN', 'NAMA BAHAN', 'TANGGAL MASUK', 'HARGA BELI', 'JUMLAH', 'TOTAL'];
    }
}

<?php

namespace App\Exports;

use App\Models\BahanKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BahanKeluarExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BahanKeluar::join('dataBahan', 'bahanKeluar.kd_bahan', '=', 'dataBahan.kd_bahan')
            ->select('bahanKeluar.id_bahanKeluar', 'bahanKeluar.kd_bahan', 'dataBahan.nm_bahan', 'bahanKeluar.tgl_keluar', 'dataBahan.harga_beli', 'bahanKeluar.jumlah', 'bahanKeluar.total')->get();
    }

    public function headings(): array
    {
        return ['ID', 'KODE BAHAN', 'NAMA BAHAN', 'TANGGAL KELUAR', 'HARGA BELI', 'JUMLAH', 'TOTAL'];
    }
}

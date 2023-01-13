<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMasuk extends Model
{
    use HasFactory;

    protected $table = 'ProdukMasuk';

    protected $primaryKey = 'id_produkMasuk';

    protected $fillable = [
        'kd_produk',
        'kd_resep',
        'nip_karyawan',
        'jumlah',
        'tgl_produksi',
        'tgl_expired',
        'modal',
        'total',
        'ket',
    ];
}

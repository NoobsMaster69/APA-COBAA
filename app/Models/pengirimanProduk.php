<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengirimanProduk extends Model
{
    use HasFactory;

    protected $table = 'pengirimanProduk';

    protected $primaryKey = 'id_pengirimanProduk';

    protected $fillable =
    [
        'id_pengirimanProduk',
        'kd_produk',
        'tgl_pengiriman',
        'id_produkKeluar',
        'kd_sopir',
        'kd_mobil',
        'status',
    ];
}

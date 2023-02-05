<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasiPengiriman extends Model
{
    use HasFactory;

    protected $table = 'lokasiPengiriman';

    protected $primaryKey = 'id_lokasiPengiriman';

    protected $fillable =
    [
        'id_lokasiPengiriman',
        'tempat',
        'alamat',
    ];
}

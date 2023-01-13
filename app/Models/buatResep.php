<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buatResep extends Model
{
    use HasFactory;

    protected $table = 'buatresep';

    protected $fillable = [
        'kd_resep',
        'kd_bahan',
        'jumlah'
    ];
}

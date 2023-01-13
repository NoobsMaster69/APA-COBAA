<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'Jabatan';

    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nm_jabatan'
    ];
}

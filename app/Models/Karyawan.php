<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'Karyawan';

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nip',
        'nm_karyawan',
        'kd_jabatan',
        'jenis_kelamin',
        'ttl',
        'no_telp',
        'alamat',
        'role',
        'foto'
    ];
}

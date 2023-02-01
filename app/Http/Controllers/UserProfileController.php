<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Sopir;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::where('nip', auth()->user()->nip)->first();
        $sopir = Sopir::where('no_ktp', auth()->user()->nip)->first();

        // if (!empty($karyawan) || $karyawan == !null) {
        //     return view('pages.UserProfile.index', ['tittle' => 'Profile User', 'karyawan' => $karyawan]);
        // } elseif (!empty($sopir) || $sopir == !null) {
        //     return view('pages.UserProfile.index', ['tittle' => 'Profile User', 'sopir' => $sopir]);
        // }

        return view('pages.UserProfile.index', ['tittle' => 'Profile User', 'sopir' => $sopir, 'karyawan' => $karyawan]);
    }
}

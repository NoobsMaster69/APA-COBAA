<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MobilController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Mobil::class);

        // kode otomatis
        $kode = Mobil::max('kd_mobil');
        $kode = (int) substr($kode, 4, 4);
        $kode = $kode + 1;
        $kode_otomatis = "MBL" . sprintf("%03s", $kode);

        $mobil = Mobil::all();

        // mengirim tittle dan judul ke view
        return view(
            'mobil.index',
            [
                'mobil' => $mobil,
                'kode_otomatis' => $kode_otomatis,
                'tittle' => 'Data Mobil',
                'judul' => 'Data Mobil',
                'menu' => 'Data Mobil',
                'submenu' => 'Data Mobil'
            ]
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->authorize('create', Mobil::class);

        // mengubah nama validasi
        $messages = [
            'kd_mobil.required' => 'Kode Mobil tidak boleh kosong',
            'merk.required' => 'Merk tidak boleh kosong',
            'plat_nomor.required' => 'Plat Nomor tidak boleh kosong',
            'plat_nomor.unique' => 'Plat Nomor sudah terdaftar',
            'ket.required' => 'Keterangan tidak boleh kosong',
        ];

        $request->validate([
            'kd_mobil' => 'required',
            'merk' => 'required',
            'plat_nomor' => 'required|unique:mobil,plat_nomor',
            'ket' => 'required'
        ], $messages);

        Mobil::create($request->all());

        Alert::success('Data Mobil', 'Berhasil ditambahakan!');
        return redirect('mobil');
    }

    public function show(Mobil $mobil)
    {
        //
    }


    public function edit(Mobil $mobil)
    {
        $this->authorize('update', $mobil);

        return view(
            'mobil.edit',
            compact('mobil'),
            [
                'tittle' => 'Edit Data Mobil',
                'judul' => 'Edit Data Mobil',
                'menu' => 'Data Mobil',
                'submenu' => 'Edit Data Mobil'
            ]
        );
    }

    public function update(Request $request, Mobil $mobil)
    {
        $this->authorize('update', $mobil);

        // mengubah nama validasi
        $messages = [
            'kd_mobil.required' => 'Kode Mobil tidak boleh kosong',
            'merk.required' => 'Merk tidak boleh kosong',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'plat_nomor.required' => 'Plat Nomor tidak boleh kosong',
            'plat_nomor.unique' => 'Plat Nomor sudah terdaftar',
        ];

        $rules = [
            'kd_mobil' => 'required',
            'merk' => 'required',
            'ket' => 'required'
        ];

        if ($request->plat_nomor != $mobil->plat_nomor) {
            $rules['plat_nomor'] = 'required|unique:mobil,plat_nomor';
        };

        $validateData = $request->validate($rules, $messages);
        $mobil->update($validateData);
        Alert::success('Data Mobil', 'Berhasil diubah!');
        return redirect('mobil');
    }

    public function destroy(Mobil $mobil)
    {
        $this->authorize('delete', $mobil);

        Mobil::destroy($mobil->kd_mobil);
        Alert::success('Data Mobil', 'Berhasil dihapus!');
        return redirect('mobil');
    }
}

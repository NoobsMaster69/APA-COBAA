<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{

    public function index()
    {
        // mengirim tittle dan judul ke view
        return view(
            'jabatan.index',
            [
                'jabatan' => Jabatan::all(),
                'tittle' => 'Data Jabatan',
                'judul' => 'Data Jabatan',
                'menu' => 'Data Jabatan',
                'submenu' => 'Data Jabatan'
            ]
        );
    }


    public function store(Request $request)
    {
        // mengubah error ke bahasa indonesia
        $messages = [
            'required' => 'Nama Jabatan tidak boleh kosong',
            'unique' => 'Nama Jabatan sudah ada',
        ];

        // validasi data
        $request->validate([
            'nm_jabatan' => 'required|unique:Jabatan,nm_jabatan',
        ], $messages);


        Jabatan::create($request->all());

        Alert::success('Data Jabatan', 'Berhasil Ditambahkan!');
        return redirect('jabatan');
    }


    public function show($id)
    {
        //
    }


    public function edit(Jabatan $jabatan)
    {
        return view(
            'jabatan.edit',
            compact('jabatan'),
            [
                'tittle' => 'Edit Data Jabatan',
                'judul' => 'Edit Data Jabatan',
                'menu' => 'Data Jabatan',
                'submenu' => 'Edit Data Jabatan'
            ]
        );
    }


    public function update(Request $request, Jabatan $jabatan)
    {
        // mengubah error ke bahasa indonesia
        $messages = [
            'required' => 'Nama Jabatan tidak boleh kosong',
            'unique' => 'Nama Jabatan sudah ada',
        ];

        $request->validate([
            'nm_jabatan' => 'required|unique:Jabatan,nm_jabatan',
        ], $messages);

        $jabatan->update($request->all());
        Alert::success('Data Jabatan', 'Berhasil diubah!');
        return redirect('jabatan');
    }


    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        Alert::success('Data Jabatan', 'Berhasil dihapus!');
        return redirect('jabatan');
    }
}

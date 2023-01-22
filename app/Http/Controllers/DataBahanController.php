<?php

namespace App\Http\Controllers;

use App\Models\DataBahan;
use App\Models\Satuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DataBahanController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $paginate = $request->paginate;


        // menyatukan search dengan join tabel
        $dataBahan = DataBahan::join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('databahan.*', 'satuan.nm_satuan')
            ->where('databahan.kd_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('databahan.nm_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('satuan.nm_satuan', 'LIKE', '%' . $search . '%')
            ->orWhere('databahan.harga_beli', 'LIKE', '%' . $search . '%')
            ->orWhere('databahan.stok', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate($paginate)->withQueryString();

        // mengirim tittle dan judul ke view
        return view('pages.dataBahan.index', [
            'dataBahan' => $dataBahan,
            'tittle' => 'Data Bahan',
            'judul' => 'Data Bahan',
            'menu' => 'Data Bahan',
            'submenu' => 'Data Bahan'
        ]);
    }


    public function create()
    {
        $kode = DataBahan::max('kd_bahan');
        $kode = (int) substr($kode, 3, 3);
        $kode = $kode + 1;
        $kode_otomatis = "BHN" . sprintf("%03s", $kode);


        $satuan = Satuan::all();

        return view(
            'pages.databahan.create',
            ['kode_otomatis' => $kode_otomatis, 'satuan' => $satuan],
            [
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Data Bahan',
                'menu' => 'Data Bahan',
                'submenu' => 'Tambah Data'
            ]
        );
    }


    public function store(Request $request)
    {
        // mengubah nama validasi
        $messages = [
            'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
            'nm_bahan.required' => 'Nama Bahan tidak boleh kosong',
            'nm_bahan.min' => 'Nama Bahan minimal 3 karakter',
            'nm_bahan.max' => 'Nama Bahan maksimal 50 karakter',
            'kd_satuan.required' => 'Kode Satuan tidak boleh kosong',
            'harga_beli.required' => 'Harga Beli tidak boleh kosong',
            'harga_beli.numeric' => 'Harga Beli harus berupa angka',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.numeric' => 'Stok harus berupa angka',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'ket.min' => 'Keterangan tidak boleh kosong',
            'ket.min' => 'Keterangan minimal 3 karakter',
        ];

        $request->validate([
            'kd_bahan' => 'required|min:3|max:10',
            'nm_bahan' => 'required|min:3|max:50',
            'kd_satuan' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required|numeric',
            'ket' => 'required|min:3',
        ], $messages);

        DataBahan::create($request->all());

        Alert::success('Data Bahan', 'Berhasil Ditambahkan');

        return redirect('/dataBahan');
    }

    public function show(DataBahan $dataBahan)
    {
        //
    }

    public function edit(DataBahan $dataBahan)
    {

        $dataBahan = DB::table('databahan')->join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')->select('databahan.*', 'satuan.nm_satuan')->where('kd_satuan', $dataBahan->kd_satuan)->first();

        $satuan = Satuan::all();
        return view(
            'pages.DataBahan.edit',
            compact('dataBahan', 'satuan'),
            ['tittle' => 'Edit Data', 'judul' => 'Edit Data Bahan', 'menu' => 'Data Bahan', 'submenu' => 'Edit Data']
        );
    }

    public function update(Request $request, DataBahan $dataBahan)
    {

        // mengubah nama validasi
        $messages = [
            'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
            'nm_bahan.required' => 'Nama Bahan tidak boleh kosong',
            'nm_bahan.min' => 'Nama Bahan minimal 3 karakter',
            'nm_bahan.max' => 'Nama Bahan maksimal 50 karakter',
            'kd_satuan.required' => 'Kode Satuan tidak boleh kosong',
            'harga_beli.required' => 'Harga Beli tidak boleh kosong',
            'harga_beli.numeric' => 'Harga Beli harus berupa angka',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.numeric' => 'Stok harus berupa angka',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'ket.min' => 'Keterangan tidak boleh kosong',
            'ket.min' => 'Keterangan minimal 3 karakter',
        ];

        $request->validate([
            'kd_bahan' => 'required|min:3|max:10',
            'nm_bahan' => 'required|min:3|max:50',
            'kd_satuan' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required|numeric',
            'ket' => 'required|min:3',
        ], $messages);


        $dataBahan->update($request->all());

        Alert::success('Data Bahan', 'Berhasil Diubah');


        return redirect('/dataBahan');
    }

    public function destroy(DataBahan $dataBahan, Request $request)
    {

        $dataBahan->delete('kd_bahan', $request->kd_bahan);

        Alert::success('Data Bahan', 'Berhasil Dihapus');

        return redirect('/dataBahan');
    }
}

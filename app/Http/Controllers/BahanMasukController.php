<?php

namespace App\Http\Controllers;

use App\Models\BahanMasuk;
use App\Models\DataBahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BahanMasukController extends Controller
{

    public function index()
    {
        // $this->authorize('viewAny', BahanMasuk::class);

        // join table bahan masuk dan data bahan
        $bahanMasuk = BahanMasuk::join('dataBahan', 'bahanMasuk.kd_bahan', '=', 'dataBahan.kd_bahan')->join('satuan', 'dataBahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('bahanMasuk.*', 'dataBahan.nm_bahan', 'dataBahan.kd_satuan', 'dataBahan.harga_beli', 'satuan.nm_satuan')
            ->get();


        // mengirim tittle dan judul ke view
        return view(
            'pages.bahanMasuk.index',
            ['bahanMasuk' => $bahanMasuk],
            [
                'tittle' => 'Pembelian Bahan',
                'judul' => 'Pembelian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Pembelian Bahan'
            ]
        );
    }


    public function create()
    {
        // $this->authorize('create', BahanMasuk::class);

        // join dengan tabel satuan
        $dataBahan = DataBahan::join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('databahan.*', 'satuan.nm_satuan')
            ->get();

        return view(
            'pages.bahanMasuk.create',
            ['dataBahan' => $dataBahan],
            [
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Pembelian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Tambah Data'
            ]
        );
    }


    public function store(Request $request)
    {
        // $this->authorize('create', BahanMasuk::class);

        // stok bahan bertambah
        $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();
        $stok->stok = $stok->stok + $request->jumlah;
        $stok->save();

        // merubah harga_beli dan jumlah menjadi integer
        $harga_beli = (int) $request->harga_beli;
        $jumlah = (int) $request->jumlah;

        // mencari total harga
        $total = $harga_beli * $jumlah;

        // mengubah nama validasi
        $messages = [
            'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
            'nm_bahan.required' => 'Nama Bahan tidak boleh kosong',
            'tgl_masuk.required' => 'Tanggal Masuk tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'ket.required' => 'Keterangan tidak boleh kosong',
        ];

        $request->validate([
            'kd_bahan' => 'required',
            'nm_bahan' => 'required',
            'tgl_masuk' => 'required',
            'jumlah' => 'required',
            'ket' => 'required',
        ], $messages);

        // mengubah format tgl_masuk dari text ke date
        $tgl_masuk = date('Y-m-d', strtotime($request->tgl_masuk));

        BahanMasuk::create([
            'kd_bahan' => $request->kd_bahan,
            'nm_bahan' => $request->nm_bahan,
            'tgl_masuk' => $tgl_masuk,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);


        Alert::success('Data Pembelian', 'Berhasil Ditambahkan!');
        return redirect('bahanmasuk');
    }


    public function show(BahanMasuk $bahanMasuk)
    {
        //
    }


    public function edit(bahanMasuk $bahanMasuk)
    {
        $this->authorize('update', $bahanMasuk);

        // join tabel satuan
        $dataBahan = DataBahan::join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('databahan.*', 'satuan.nm_satuan')
            ->where('kd_bahan', $bahanMasuk->kd_bahan)
            ->first();

        return view(
            'pages.bahanMasuk.edit',
            compact('bahanMasuk', 'dataBahan'),
            // ['dataBahan' => $dataBahan],
            [
                'tittle' => 'Edit Data',
                'judul' => 'Edit Data Pembelian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Edit Data'
            ]
        );
    }


    public function update(Request $request, bahanMasuk $bahanMasuk)
    {
        // $this->authorize('update', $bahanMasuk);

        // cek apakah bahannya di ubah
        if ($request->has('kd_bahan')) {

            // mengembalikan stok bahan yg lama
            $stok = DataBahan::where('kd_bahan', $bahanMasuk->kd_bahan)->first();
            $stok->stok = $stok->stok - $bahanMasuk->jumlah;
            $stok->save();

            // update stok bahan baru
            $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();
            $stok->stok = $stok->stok + $request->jumlah;
            $stok->save();

            // merubah harga_beli dan jumlah menjadi integer
            $harga_beli = (int) $stok->harga_beli;
            $jumlah = (int) $request->jumlah;

            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'tgl_masuk.required' => 'Tanggal Masuk tidak boleh kosong',
                'ket.required' => 'Keterangan tidak boleh kosong',
                'ket.min' => 'Keterangan minimal 3 karakter',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'jumlah' => 'required',
                'tgl_masuk' => 'required',
                'ket' => 'required|min:3',
            ], $messages);

            $input = $request->all();

            // mencari total harga
            $total = $harga_beli * $jumlah;
            $input['total'] = $total;

            $bahanMasuk->update($input);

            // Alert::success('Data Pembelian', 'Berhasil diubah!');
            return redirect('bahanMasuk');
        } else {
            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'tgl_masuk.required' => 'Tanggal Masuk tidak boleh kosong',
                'ket.required' => 'Keterangan tidak boleh kosong',
                'ket.min' => 'Keterangan minimal 3 karakter',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'jumlah' => 'required',
                'tgl_masuk' => 'required',
                'ket' => 'required|min:3',
            ], $messages);

            if ($request->has('jumlah')) {

                // update stok bahan
                $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();
                $stok->stok = $stok->stok + $request->jumlah;
                $stok->save();

                // merubah harga_beli dan jumlah menjadi integer
                $harga_beli = (int) $stok->harga_beli;
                $jumlah = (int) $request->jumlah;

                $input = $request->all();

                // mencari total harga
                $total = $harga_beli * $jumlah;
                $input['total'] = $total;

                $bahanMasuk->update($input);

                // Alert::success('Data Pembelian', 'Berhasil diubah!');
                return redirect('bahanMasuk');
            } else {
                $input = $request->all();
                $bahanMasuk->update($input);

                // Alert::success('Data Pembelian', 'Berhasil diubah!');
                return redirect('bahanMasuk');
            }
        }
    }


    public function destroy(bahanMasuk $bahanMasuk)
    {
        $this->authorize('delete', $bahanMasuk);

        // update stok bahan
        $stok = DataBahan::where('kd_bahan', $bahanMasuk->kd_bahan)->first();
        $stok->stok = $stok->stok - $bahanMasuk->jumlah;
        $stok->save();

        $bahanMasuk->delete();
        // Alert::success('Data Pembelian', 'Berhasil dihapus!');
        return redirect('bahanMasuk');
    }
}

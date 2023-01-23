<?php

namespace App\Http\Controllers;

use App\Models\BahanMasuk;
use App\Models\DataBahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BahanMasukController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', BahanMasuk::class);

        $search = $request->search;

        // menyatukan search dengan join tabel
        $bahanMasuk = BahanMasuk::join('dataBahan', 'bahanMasuk.kd_bahan', '=', 'dataBahan.kd_bahan')->join('satuan', 'dataBahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('bahanMasuk.*', 'dataBahan.nm_bahan', 'dataBahan.kd_satuan', 'dataBahan.harga_beli', 'satuan.nm_satuan')
            ->where('bahanMasuk.kd_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanMasuk.nm_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('satuan.nm_satuan', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanMasuk.tgl_masuk', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanMasuk.jumlah', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanMasuk.ket', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(10)->withQueryString();


        // mengirim tittle dan judul ke view
        return view(
            'pages.bahanMasuk.index',
            [
                'bahanMasuk' => $bahanMasuk,
                'tittle' => 'Data Pembelian Bahan',
                'judul' => 'Data Pembelian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Data Pembelian Bahan'
            ]
        );
    }


    public function create()
    {
        $this->authorize('create', BahanMasuk::class);

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
        $this->authorize('create', BahanMasuk::class);

        // mengubah nama validasi
        $messages = [
            'kd_bahan.required' => 'Pilih Kode Bahan terlebih dahulu',
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

        // stok bahan bertambah
        $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();
        $stok->stok = $stok->stok + $request->jumlah;
        $stok->save();

        // merubah harga_beli dan jumlah menjadi integer
        $harga_beli = (int) $request->harga_beli;
        $jumlah = (int) $request->jumlah;

        // mencari total harga
        $total = $harga_beli * $jumlah;


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
        return redirect('/bahanMasuk');
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
        $this->authorize('update', $bahanMasuk);

        // cek apakah bahannya di ubah
        if ($request->has('kd_bahan')) {

            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Pilih Kode Bahan terlebih dahulu',
                'tgl_masuk.required' => 'Tanggal Masuk tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'ket.required' => 'Keterangan tidak boleh kosong',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'tgl_masuk' => 'required',
                'jumlah' => 'required',
                'ket' => 'required',
            ], $messages);
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

            $input = $request->all();

            // mengubah format tgl_masuk dari text ke date
            $tgl_masuk = date('Y-m-d', strtotime($request->tgl_masuk));


            // mencari total harga
            $total = $harga_beli * $jumlah;
            $input['total'] = $total;
            $input['tgl_masuk'] = $tgl_masuk;
            $bahanMasuk->update($input);


            Alert::success('Data Pembelian', 'Berhasil diubah!');
            return redirect('/bahanMasuk');
        } else {
            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Pilih Kode Bahan terlebih dahulu',
                'tgl_masuk.required' => 'Tanggal Masuk tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'ket.required' => 'Keterangan tidak boleh kosong',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'tgl_masuk' => 'required',
                'jumlah' => 'required',
                'ket' => 'required',
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

                // mengubah format tgl_masuk dari text ke date
                $tgl_masuk = date('Y-m-d', strtotime($request->tgl_masuk));

                // mencari total harga
                $total = $harga_beli * $jumlah;
                $input['total'] = $total;
                $input['tgl_masuk'] = $tgl_masuk;

                $bahanMasuk->update($input);

                Alert::success('Data Pembelian', 'Berhasil diubah!');
                return redirect('/bahanmasuk');
            } else {
                // mengubah format tgl_masuk dari text ke date
                $tgl_masuk = date('Y-m-d', strtotime($request->tgl_masuk));

                $input = $request->all();
                $input['tgl_masuk'] = $tgl_masuk;
                $bahanMasuk->update($input);

                Alert::success('Data Pembelian', 'Berhasil diubah!');
                return redirect('/bahanMasuk');
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
        Alert::success('Data Pembelian', 'Berhasil dihapus!');
        return redirect('/bahanMasuk');
    }
}

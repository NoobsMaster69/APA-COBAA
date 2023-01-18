<?php

namespace App\Http\Controllers;

use App\Models\ProdukJadi;
use App\Models\ProdukMasuk;
use App\Models\Resep;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $this->authorize('viewAny', ProdukMasuk::class);

        // join table produkMasuk dengan produkJadi
        $produkMasuk = ProdukMasuk::join('produkJadi', 'produkMasuk.kd_produk', '=', 'produkJadi.kd_produk')->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')->join('users', 'produkMasuk.nip_karyawan', '=', 'users.nip')->join('resep', 'produkMasuk.kd_resep', '=', 'resep.kd_resep')->select('produkMasuk.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'satuan.nm_satuan', 'users.name', 'resep.kd_resep')
            ->get();

        // ambil nama karyawan dari session
        $nama = session('name');
        // mengirim tittle dan judul ke view
        return view(
            'pages.produkMasuk.index',
            ['produkMasuk' => $produkMasuk, 'nama' => $nama],
            [
                'tittle' => 'Pembuatan Produk',
                'judul' => 'Pembuatan Produk',
                'menu' => 'Produk',
                'submenu' => 'Pembuatan Produk'
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', ProdukMasuk::class);
        // join dengan tabel satuan
        $produkJadi = ProdukJadi::join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkJadi.*', 'satuan.nm_satuan')
            ->get();

        return view(
            'pages.produkMasuk.create',
            ['produkJadi' => $produkJadi],
            [
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Pembuatan Produk',
                'menu' => 'Produk Jadi',
                'submenu' => 'Tambah Data'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', ProdukMasuk::class);


        // mengubah nama validasi
        $messages = [
            'kd_produk.required' => 'Kode Produk Harus Diisi',
            'tgl_produksi.required' => 'Tanggal Produksi Harus Diisi',
            'tgl_expired.required' => 'Tanggal Expired Harus Diisi',
            'modal.required' => 'Modal Harus Diisi',
            'modal.numeric' => 'Modal Harus Angka',
            'jumlah.required' => 'Jumlah Harus Diisi',
            'jumlah.numeric' => 'Jumlah Harus Angka',
            'ket.required' => 'Keterangan Harus Diisi',
        ];

        $request->validate([
            'kd_produk' => 'required',
            'tgl_produksi' => 'required',
            'tgl_expired' => 'required',
            'modal' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'ket' => 'required',
        ], $messages);

        $nip = auth()->user()->nip;

        $resep = Resep::where('kd_produk', $request->kd_produk)->get();
        if (empty($resep->first())) {
            Alert::warning('Resep untuk Produk ini belum tersedia', 'Silahkan tambahkan resep terlebih dahulu!');
            return redirect('resep');
        } else {
            $resep = $resep->first()->kd_resep;
        }

        // stok bahan bertambah
        $stok = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
        $stok->stok = $stok->stok + $request->jumlah;
        $stok->save();

        $total = $request->modal * $request->jumlah;

        ProdukMasuk::create([
            'kd_produk' => $request->kd_produk,
            'kd_resep' => $resep,
            'nip_karyawan' => $nip,
            'tgl_produksi' => $request->tgl_produksi,
            'tgl_expired' => $request->tgl_expired,
            'modal' => $request->modal,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);


        Alert::success('Data Pembuatan Produk', 'Berhasil Ditambahkan!');
        return redirect('produkMasuk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukMasuk $produkMasuk)
    {
        // $this->authorize('delete', $produkMasuk);

        // update stok produk jadi
        $stok = ProdukJadi::where('kd_produk', $produkMasuk->kd_produk)->first();
        $stok->stok = $stok->stok - $produkMasuk->jumlah;
        $stok->save();

        $produkMasuk->delete();
        Alert::success('Data Pembuatan Produk', 'Berhasil Dihapus!');
        return redirect('pages.produkMasuk');
    }
}

// cara translate bulan dari bahasa inggris ke bahasa indonesia di laravel

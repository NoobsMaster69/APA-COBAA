<?php

namespace App\Http\Controllers;

use App\Models\ProdukJadi;
use App\Models\ProdukKeluar;
use App\Models\ProdukMasuk;
use App\Models\Resep;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', ProdukKeluar::class);

        // join table produkKeluar dengan produkJadi
        $produkKeluar = ProdukKeluar::join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')->join('users', 'produkKeluar.nip_karyawan', '=', 'users.nip')->join('produkMasuk', 'produkKeluar.kd_produk', '=', 'produkMasuk.kd_produk')->select('produkKeluar.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'satuan.nm_satuan', 'users.name', 'produkMasuk.tgl_expired')
            ->get();

        // ambil nama karyawan dari session
        $nama = session('name');
        // mengirim tittle dan judul ke view
        return view(
            'produkKeluar.index',
            ['produkKeluar' => $produkKeluar, 'nama' => $nama],
            [
                'tittle' => 'Penjualan Produk',
                'judul' => 'Penjualan Produk',
                'menu' => 'Produk',
                'submenu' => 'Penjualan Produk'
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
        $this->authorize('create', ProdukKeluar::class);
        // join dengan tabel satuan
        $produkJadi = ProdukJadi::join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkJadi.*', 'satuan.nm_satuan')
            ->get();

        return view(
            'produkKeluar.create',
            ['produkJadi' => $produkJadi],
            [
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Penjualan Produk',
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
        $this->authorize('create', ProdukKeluar::class);

        // mengubah nama validasi
        $messages = [
            'kd_produk.required' => 'Kode Produk Harus Diisi',
            'tgl_keluar.required' => 'Tanggal Keluar Harus Diisi',
            'jumlah.required' => 'Jumlah Harus Diisi',
            'jumlah.numeric' => 'Jumlah Harus Angka',
            'ket.required' => 'Keterangan Harus Diisi',
        ];

        $request->validate([
            'kd_produk' => 'required',
            'tgl_keluar' => 'required',
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
        $stok->stok = $stok->stok - $request->jumlah;
        $stok->save();

        $harga_jual = ProdukJadi::where('kd_produk', $request->kd_produk)->first()->harga_jual;

        $total = $harga_jual * $request->jumlah;

        ProdukKeluar::create([
            'kd_produk' => $request->kd_produk,
            'nip_karyawan' => $nip,
            'tgl_keluar' => $request->tgl_keluar,
            'harga_jual' => $harga_jual,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);


        Alert::success('Data Penjualan Produk', 'Berhasil Ditambahkan!');
        return redirect('produkKeluar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukKeluar  $produkKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukKeluar $produkKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukKeluar  $produkKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukKeluar $produkKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukKeluar  $produkKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukKeluar $produkKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukKeluar  $produkKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukKeluar $produkKeluar)
    {
        //
    }
}

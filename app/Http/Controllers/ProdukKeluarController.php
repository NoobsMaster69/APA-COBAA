<?php

namespace App\Http\Controllers;

use App\Models\pengirimanProduk;
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
    public function index(Request $request)
    {
        $this->authorize('viewAny', ProdukKeluar::class);

        $search = $request->search;

        // menyatukan search dengan join table
        $produkKeluar = ProdukKeluar::join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
            ->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->join('users', 'produkKeluar.nip_karyawan', '=', 'users.nip')
            ->select('produkKeluar.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'satuan.nm_satuan', 'users.name')
            ->where('produkKeluar.kd_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('produkJadi.nm_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('satuan.nm_satuan', 'LIKE', '%' . $search . '%')
            ->orWhere('produkKeluar.tgl_keluar', 'LIKE', '%' . $search . '%')
            ->orWhere('produkKeluar.jumlah', 'LIKE', '%' . $search . '%')
            ->orWhere('produkKeluar.ket', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(10)->withQueryString();

        // mengambil id_produkKeluar dari tabel pengirimanProduk
        // $id_produkKeluar = pengirimanProduk::select('id_produkKeluar', $produkKeluar->id_produkKeluar)->get();

        foreach ($produkKeluar as $keluar) {
            // dd($keluar->id_produkKeluar);
            $id_produkKeluar = pengirimanProduk::where('id_produkKeluar', $keluar->id_produkKeluar)->first()->id_produkKeluar;
        }



        // dd($id_produkKeluar);

        // cek apakah id produkKeluar sudah ada di pengirimanProduk
        // foreach ($produkKeluar as $key => $value) {
        //     foreach ($id_produkKeluar as $key2 => $value2) {
        //         if ($value->id_produkKeluar == $value2->id_produkKeluar) {
        //             $status = 1;
        //         } else {
        //             $status = 0;
        //         }
        //     }
        // }

        // dd($status);

        // jika id_produkKeluar di tabel pengirimanProduk sudah ada maka status 'Dikirim'
        // dd($value->id_produkKeluar);

        // looping 

        // if ($produkKeluar->id_produkKeluar == $id_produkKeluar) {
        //     $status = 1;
        // } else {
        //     $status = 0;
        // }

        // $status = 0;

        // ambil nama karyawan dari session
        $nama = session('name');
        // mengirim tittle dan judul ke view
        return view(
            'pages.produkKeluar.index',
            [
                'produkKeluar' => $produkKeluar,
                'nama' => $nama,
                'id_produkKeluar' => $id_produkKeluar,
                'tittle' => 'Data Penjualan Produk',
                'judul' => 'Data Penjualan Produk',
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
            'pages.produkKeluar.create',
            ['produkJadi' => $produkJadi],
            [
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Penjualan Produk',
                'menu' => 'Penjualan Produk',
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

        // $resep = Resep::where('kd_produk', $request->kd_produk)->get();
        // if (empty($resep->first())) {
        //     Alert::warning('Resep untuk Produk ini belum tersedia', 'Silahkan tambahkan resep terlebih dahulu!');
        //     return redirect('resep');
        // } else {
        //     $resep = $resep->first()->kd_resep;
        // }

        // stok bahan bertambah
        $stok = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
        $stok->stok = $stok->stok - $request->jumlah;
        $stok->save();

        // ubah format tgl_keluar dari varchar ke date
        $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar)); // $tgl_keluar

        $harga_jual = ProdukJadi::where('kd_produk', $request->kd_produk)->first()->harga_jual;

        $total = $harga_jual * $request->jumlah;

        ProdukKeluar::create([
            'kd_produk' => $request->kd_produk,
            'nip_karyawan' => $nip,
            'tgl_keluar' => $tgl_keluar,
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
        $this->authorize('update', $produkKeluar);

        // join dengan tabel satuan
        $produkJadi = ProdukJadi::join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkJadi.*', 'satuan.nm_satuan')
            ->where('kd_produk', $produkKeluar->kd_produk)
            ->first();

        return view(
            'pages.produkKeluar.edit',
            ['produkKeluar' => $produkKeluar, 'produkJadi' => $produkJadi],
            [
                'tittle' => 'Edit Data',
                'judul' => 'Edit Penjualan Produk',
                'menu' => 'Penjualan Produk',
                'submenu' => 'Edit Data'
            ]
        );
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

        $this->authorize('update', $produkKeluar);

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

        // mengembalikan stok produk
        $stok = ProdukJadi::where('kd_produk', $produkKeluar->kd_produk)->first();
        $stok->stok = $stok->stok + $produkKeluar->jumlah;
        $stok->save();

        // update stok produk
        $stok = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
        $stok->stok = $stok->stok - $request->jumlah;
        $stok->save();

        // ubah format tgl_keluar dari varchar ke date
        $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar));

        $harga_jual = ProdukJadi::where('kd_produk', $request->kd_produk)->first()->harga_jual;

        $total = $harga_jual * $request->jumlah;

        $produkKeluar->update([
            'kd_produk' => $request->kd_produk,
            'nip_karyawan' => $nip,
            'tgl_keluar' => $tgl_keluar,
            'harga_jual' => $harga_jual,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);

        Alert::success('Data Penjualan Produk', 'Berhasil Diubah!');
        return redirect('produkKeluar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukKeluar  $produkKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukKeluar $produkKeluar)
    {
        $this->authorize('delete', $produkKeluar);

        // update stok produk
        $stok = ProdukJadi::where('kd_produk', $produkKeluar->kd_produk)->first();
        $stok->stok = $stok->stok + $produkKeluar->jumlah;
        $stok->save();

        $produkKeluar->delete();
        Alert::success('Data Penjualan Produk', 'Berhasil Dihapus!');
        return redirect('produkKeluar');
    }
}

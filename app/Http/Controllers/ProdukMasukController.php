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
    public function index(Request $request)
    {

        // $this->authorize('viewAny', ProdukMasuk::class);

        $search = $request->search;

        // menyatukan search dengan join table
        $produkMasuk = produkMasuk::join('produkJadi', 'produkMasuk.kd_produk', '=', 'produkJadi.kd_produk')->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')->join('users', 'produkMasuk.nip_karyawan', '=', 'users.nip')->select('produkMasuk.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'produkJadi.modal', 'satuan.nm_satuan', 'users.name')
            ->where('produkMasuk.kd_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('produkJadi.nm_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('satuan.nm_satuan', 'LIKE', '%' . $search . '%')
            ->orWhere('produkMasuk.tgl_produksi', 'LIKE', '%' . $search . '%')
            ->orWhere('produkJadi.modal', 'LIKE', '%' . $search . '%')
            ->orWhere('produkMasuk.jumlah', 'LIKE', '%' . $search . '%')
            ->orWhere('produkMasuk.ket', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(10)->withQueryString();

        // ambil nama karyawan dari session
        $nama = session('name');
        // mengirim tittle dan judul ke view
        return view(
            'pages.produkMasuk.index',
            [
                'produkMasuk' => $produkMasuk,
                'nama' => $nama,
                'tittle' => 'Data Pembuatan Produk',
                'judul' => 'Data Pembuatan Produk',
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

        // dd($request->all());

        // mengubah nama validasi
        $messages = [
            'kd_produk.required' => 'Kode Produk Harus Diisi',
            'tgl_produksi.required' => 'Tanggal Produksi Harus Diisi',
            'tgl_expired.required' => 'Tanggal Expired Harus Diisi',
            'jumlah.required' => 'Jumlah Harus Diisi',
            'jumlah.numeric' => 'Jumlah Harus Angka',
            'ket.required' => 'Keterangan Harus Diisi',
        ];

        $request->validate([
            'kd_produk' => 'required',
            'tgl_produksi' => 'required',
            'tgl_expired' => 'required',
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

        // ubah format tgl_keluar dari varchar ke date
        $tgl_produksi = date('Y-m-d', strtotime($request->tgl_produksi));

        $tgl_expired = date('Y-m-d', strtotime($request->tgl_expired));

        $modal = ProdukJadi::where('kd_produk', $request->kd_produk)->first()->modal;

        $total = $modal * $request->jumlah;

        ProdukMasuk::create([
            'kd_produk' => $request->kd_produk,
            'nip_karyawan' => $nip,
            'tgl_produksi' => $tgl_produksi,
            'tgl_expired' => $tgl_expired,
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
        // $this->authorize('update', $produkMasuk);

        // join dengan tabel satuan
        $produkJadi = ProdukJadi::join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkJadi.*', 'satuan.nm_satuan')
            ->where('kd_produk', $produkMasuk->kd_produk)
            ->first();

        return view(
            'pages.produkMasuk.edit',
            ['produkMasuk' => $produkMasuk, 'produkJadi' => $produkJadi],
            [
                'tittle' => 'Edit Data Pembuatan Produk',
                'judul' => 'Edit Pembuatan Produk',
                'menu' => 'Produk Jadi',
                'submenu' => 'Edit Data'
            ]
        );
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
        // mengubah nama validasi
        $messages = [
            'kd_produk.required' => 'Kode Produk Harus Diisi',
            'tgl_produksi.required' => 'Tanggal Produksi Harus Diisi',
            'tgl_expired.required' => 'Tanggal Expired Harus Diisi',
            'jumlah.required' => 'Jumlah Harus Diisi',
            'jumlah.numeric' => 'Jumlah Harus Angka',
            'ket.required' => 'Keterangan Harus Diisi',
        ];

        $request->validate([
            'kd_produk' => 'required',
            'tgl_produksi' => 'required',
            'tgl_expired' => 'required',
            'jumlah' => 'required|numeric',
            'ket' => 'required',
        ], $messages);

        $nip = auth()->user()->nip;

        // mengembalikan stok produk
        $stok = ProdukJadi::where('kd_produk', $produkMasuk->kd_produk)->first();
        $stok->stok = $stok->stok - $produkMasuk->jumlah;
        $stok->save();

        // update stok produk jadi
        $stok = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
        $stok->stok = $stok->stok + $request->jumlah;
        $stok->save();

        // ubah format tgl_produksi dari varchar ke date
        $tgl_produksi = date('Y-m-d', strtotime($request->tgl_produksi));

        $tgl_expired = date('Y-m-d', strtotime($request->tgl_expired));

        $modal = ProdukJadi::where('kd_produk', $request->kd_produk)->first()->modal;

        $total = $modal * $request->jumlah;

        $produkMasuk->update([
            'kd_produk' => $request->kd_produk,
            'nip_karyawan' => $nip,
            'tgl_produksi' => $tgl_produksi,
            'tgl_expired' => $tgl_expired,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);

        Alert::success('Data Pembuatan Produk', 'Berhasil Diubah!');
        return redirect('produkMasuk');
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
        return redirect('produkMasuk');
    }
}

// cara translate bulan dari bahasa inggris ke bahasa indonesia di laravel

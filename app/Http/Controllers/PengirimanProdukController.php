<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\pengirimanProduk;
use App\Models\ProdukKeluar;
use App\Models\Sopir;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class PengirimanProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchByDate(Request $request)
    {
        // $this->authorize('create', pengirimanProduk::class);

        $dari = $request->dari;
        $sampai = $request->sampai;

        $pengirimanProduk = pengirimanProduk::oldest()->paginate(8)->withQueryString();


        return view(
            'pages.pengirimanProduk.create',
            [
                'pengirimanProduk' => $pengirimanProduk,
                'tittle' => 'Data Pengiriman Produk',
                'judul' => 'Data Pengiriman Produk',
                'menu' => 'Pengiriman',
                'submenu' => 'Data Pengiriman',
            ]
        );
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', pengirimanProduk::class);

        // join pengirimanProduk dan produkKeluar dengan produkJadi
        $pengirimanProduk = pengirimanProduk::join('produkKeluar', 'pengirimanProduk.id_produkKeluar', '=', 'produkKeluar.id_produkKeluar')
            ->join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
            ->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->join('sopir', 'pengirimanProduk.kd_sopir', '=', 'sopir.kd_sopir')
            ->join('mobil', 'pengirimanProduk.kd_mobil', '=', 'mobil.kd_mobil')
            ->join('users', 'pengirimanProduk.kd_sopir', '=', 'id_karyawan')
            ->select('pengirimanProduk.*', 'produkJadi.nm_produk', 'produkKeluar.jumlah', 'produkKeluar.kd_produk', 'satuan.nm_satuan', 'sopir.nm_sopir', 'mobil.plat_nomor', 'produkJadi.foto', 'users.role')
            ->latest()
            ->paginate(50)
            ->withQueryString();

        // menampilkan semua produkKeluar join dengan produkJadi dan satuan
        $produkKeluar = ProdukKeluar::join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
            ->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkKeluar.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'satuan.nm_satuan', 'produkJadi.foto')
            ->get();

        // cek apakah id produkKeluar sudah ada di pengirimanProduk
        foreach ($produkKeluar as $key => $value) {
            foreach ($pengirimanProduk as $key2 => $value2) {
                if ($value->id_produkKeluar == $value2->id_produkKeluar) {
                    unset($produkKeluar[$key]);
                }
            }
        }

        // membuat status ketika menunggu sopir mengkonfirmasi pengiriman
        // foreach ($pengirimanProduk as $pengiriman) {
        //     if ($pengiriman->status == 0) {
        //         $pengiriman->status = 'Menunggu Konfirmasi';
        //     } elseif ($pengiriman->status == 1) {
        //         $pengiriman->status = 'Sudah Dikonfirmasi';
        //     } elseif ($pengiriman->status == 2) {
        //         $pengiriman->status = 'Sudah Diterima';
        //     }
        // }

        return view(
            'pages.pengirimanProduk.index',
            [
                'pengirimanProduk' => $pengirimanProduk,
                'produkKeluar' => $produkKeluar,
                'tittle' => 'Data Pengiriman Produk',
                'judul' => 'Data Pengiriman Produk',
                'menu' => 'Pengiriman',
                'submenu' => 'Data Pengiriman',
            ]
        );
    }
    // public function updateStatus(Request $request)
    // {
    //     $this->authorize('view', pengirimanProduk::class);

    //     // join pengirimanProduk dan produkKeluar dengan produkJadi
    //     $pengirimanProduk = pengirimanProduk::join('produkKeluar', 'pengirimanProduk.id_produkKeluar', '=', 'produkKeluar.id_produkKeluar')
    //         ->join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
    //         ->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
    //         ->join('sopir', 'pengirimanProduk.kd_sopir', '=', 'sopir.kd_sopir')
    //         ->join('mobil', 'pengirimanProduk.kd_mobil', '=', 'mobil.kd_mobil')
    //         ->select('pengirimanProduk.*', 'produkJadi.nm_produk', 'produkKeluar.jumlah', 'produkKeluar.kd_produk', 'satuan.nm_satuan', 'sopir.nm_sopir', 'mobil.plat_nomor')
    //         ->oldest()
    //         ->paginate(8)
    //         ->withQueryString();

    //     // membuat status ketika menunggu sopir mengkonfirmasi pengiriman
    //     // foreach ($pengirimanProduk as $pengiriman) {
    //     //     if ($pengiriman->status == 0) {
    //     //         $pengiriman->status = 'Menunggu Konfirmasi';
    //     //     } elseif ($pengiriman->status == 1) {
    //     //         $pengiriman->status = 'Sudah Dikonfirmasi';
    //     //     } elseif ($pengiriman->status == 2) {
    //     //         $pengiriman->status = 'Sudah Diterima';
    //     //     }
    //     // }

    //     return view(
    //         'pages.pengirimanProduk.index',
    //         [
    //             'pengirimanProduk' => $pengirimanProduk,
    //             'tittle' => 'Data Pengiriman Produk',
    //             'judul' => 'Data Pengiriman Produk',
    //             'menu' => 'Pengiriman',
    //             'submenu' => 'Data Pengiriman',
    //         ]
    //     );
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', pengirimanProduk::class);

        // menampilkan semua produkKeluar join dengan produkJadi dan satuan
        $produkKeluar = ProdukKeluar::join('produkJadi', 'produkKeluar.kd_produk', '=', 'produkJadi.kd_produk')
            ->join('satuan', 'produkJadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkKeluar.*', 'produkJadi.nm_produk', 'produkJadi.kd_satuan', 'satuan.nm_satuan', 'produkJadi.foto')
            ->get();

        // ambil id_produkKeluar dari pengirimanProduk
        $pengirimanProduk = PengirimanProduk::select('id_produkKeluar')->get();

        // cek apakah id produkKeluar sudah ada di pengirimanProduk
        foreach ($produkKeluar as $key => $value) {
            foreach ($pengirimanProduk as $key2 => $value2) {
                if ($value->id_produkKeluar == $value2->id_produkKeluar) {
                    unset($produkKeluar[$key]);
                }
            }
        }

        $sopir = Sopir::all();
        $mobil = Mobil::all();

        return view(
            'pages.pengirimanProduk.create',
            [
                'produkKeluar' => $produkKeluar,
                'pengirimanProduk' => $pengirimanProduk,
                'sopir' => $sopir,
                'mobil' => $mobil,
                'tittle' => 'Tambah Data Pengiriman Produk',
                'judul' => 'Tambah Data Pengiriman Produk',
                'menu' => 'Pengiriman',
                'submenu' => 'Tambah Data Pengiriman',
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PengirimanProduk $pengirimanProduk)
    {
        $this->authorize('create', pengirimanProduk::class);

        // dd($request->all());

        $message = [
            'tgl_pengiriman.required' => 'Tanggal Pengiriman harus diisi',
            'id_produkKeluar.required' => 'Pilih Produk terlebih dahulu',
            'kd_sopir.required' => 'Pilih sopir terlebih dahulu',
            'kd_mobil.required' => 'Pilih mobil terlebih dahulu',
        ];

        $request->validate([
            'tgl_pengiriman' => 'required',
            'id_produkKeluar' => 'required',
            'kd_sopir' => 'required',
            'kd_mobil' => 'required',
        ], $message);

        // jika id_produkKeluar sudah ada di database maka tidak bisa diinputkan lagi
        $id_produkKeluar = $request->id_produkKeluar;
        $cek = pengirimanProduk::whereIn('id_produkKeluar', $id_produkKeluar)->get();
        if ($cek->count() > 0) {
            Alert::error('Gagal', 'Produk sudah dikirim!');
            return redirect()->back();
        }

        // update status tabel produkKeluar


        // ubah format tanggal agar bisa dimasukkan ke database
        $tgl_pengiriman = date('Y-m-d', strtotime($request->tgl_pengiriman));

        // mengambil kd_produk berdasarkan id_produkKeluar
        $kd_produk = ProdukKeluar::where('id_produkKeluar', $request->id_produkKeluar)->first();

        // update kolom stts di produkKeluar berdasarkan id_produkKeluar ek dalam database dengan cara looping setiap baris
        foreach ($request->id_produkKeluar as $id_produkKeluar) {
            $produkKeluar = ProdukKeluar::where('id_produkKeluar', $id_produkKeluar)->first();
            $produkKeluar->stts = 1;
            $produkKeluar->save();
        }
        if (!empty($request->all())) {
            // memasukkan id_produkKeluar ke dalam database dengan cara looping disetiap baris 
            foreach ($request->id_produkKeluar as $id_produkKeluar) {
                $pengirimanProduk = new pengirimanProduk;
                $pengirimanProduk->tgl_pengiriman = $tgl_pengiriman;
                $pengirimanProduk->id_produkKeluar = $id_produkKeluar;
                $pengirimanProduk->kd_produk = $kd_produk->kd_produk;
                $pengirimanProduk->kd_sopir = $request->kd_sopir;
                $pengirimanProduk->kd_mobil = $request->kd_mobil;
                $pengirimanProduk->status = 0;
                $pengirimanProduk->save();
            }



            Alert::success('Berhasil', 'Data Pengiriman berhasil ditambahkan');
            return redirect()->route('pengirimanProduk.index');
        } else {
            Alert::error('Gagal', 'Periksa Kembali Data yang anda kirimkan!');
            return redirect()->route('pengirimanProduk.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengirimanProduk  $pengirimanProduk
     * @return \Illuminate\Http\Response
     */
    public function show(pengirimanProduk $pengirimanProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengirimanProduk  $pengirimanProduk
     * @return \Illuminate\Http\Response
     */
    public function edit(pengirimanProduk $pengirimanProduk)
    {
        $pengirimanProduk = pengirimanProduk::where('id_pengirimanProduk', $pengirimanProduk->id_pengirimanProduk)->first();

        return view(
            'pages.pengirimanProduk.upload',
            [
                'pengirimanProduk' => $pengirimanProduk,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengirimanProduk  $pengirimanProduk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengirimanProduk $pengirimanProduk)
    {
        if ($image = $request->file('bukti_foto')) {
            $message = [
                'bukti_foto.required' => 'Upload Foto Bukti Pengiriman terlebih dahulu',
                'bukti_foto.image' => 'File yang anda pilih bukan foto atau gambar',
                'bukti_foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,webp',
            ];

            $request->validate([
                'bukti_foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            ], $message);
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . "webp";
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(480, 480);
            $image_resize->save(public_path($destinationPath . $profileImage));
            $pengirimanProduk->bukti_foto = "$profileImage";
            // update untuk status pengiriman
            $pengirimanProduk->status = $request->status;
            $pengirimanProduk->save();

            // Alert::success('Berhasil', 'Status Pengiriman berhasil diubah');
            return redirect()->route('pengirimanProduk.index');
        } else {
            $status = pengirimanProduk::where('id_pengirimanProduk', $pengirimanProduk->id_pengirimanProduk)->first()->status;

            if ($status == 0 || $status == 1) {
                // update untuk status pengiriman
                $pengirimanProduk->status = $request->status;
                $pengirimanProduk->save();

                // Alert::success('Berhasil', 'Status Pengiriman berhasil diubah');
                return redirect()->route('pengirimanProduk.index');
            } else {
                Alert::error('Gagal', 'Produk Sudah dibatalkan');
                return redirect()->route('pengirimanProduk.index');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengirimanProduk  $pengirimanProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengirimanProduk $pengirimanProduk)
    {
        // ambil status dari tabel pengirimanProduk berdasarkan id_pengirimanProduk
        $status = pengirimanProduk::where('id_pengirimanProduk', $pengirimanProduk->id_pengirimanProduk)->first()->status;
        if ($status == 0) {
            $produkKeluar = ProdukKeluar::where('id_produkKeluar', $pengirimanProduk->id_produkKeluar)->first();
            $produkKeluar->stts = 0;
            $produkKeluar->save();

            // hapus data pengirimanProduk
            $pengirimanProduk->delete();

            Alert::success('Berhasil', 'Data pengiriman sudah dibatalkan!');
            return redirect()->route('pengirimanProduk.index');
        } else {
            Alert::error('Gagal', 'Sopir Sudah mengirimkan produk ini');
            return redirect()->route('pengirimanProduk.index');
        }
    }
}

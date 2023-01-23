<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\BuatResep;
use App\Models\DataBahan;
use App\Models\ProdukJadi;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Resep::class);

        // $buatResep = Resep::join('buatresep', 'resep.kd_resep', '=', 'buatresep.kd_resep')
        //     ->join('produkjadi', 'resep.kd_produk', '=', 'produkjadi.kd_produk')
        //     ->select('resep.*', 'buatresep.*', 'produkjadi.*')
        //     ->distinct()
        //     ->get();
        // // menampilkan semua kd_bahan berdasarkan kd_resep dengan join
        // $dataBahan = BuatResep::join('databahan', 'buatresep.kd_bahan', '=', 'databahan.kd_bahan')
        //     ->join('resep', 'buatresep.kd_resep', '=', 'resep.kd_resep')
        //     ->join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
        //     ->select('buatresep.id_buatResep', 'databahan.nm_bahan', 'resep.kd_resep', 'satuan.nm_satuan', 'buatResep.kd_bahan', 'buatResep.jumlah', 'buatResep.kd_resep')
        //     ->groupBy('buatresep.id_buatResep', 'databahan.kd_bahan', 'databahan.nm_bahan', 'resep.kd_resep', 'satuan.nm_satuan', 'buatResep.kd_bahan', 'buatResep.jumlah', 'buatResep.kd_resep')
        //     ->get();
        $buatResep = Resep::join('buatresep', 'resep.kd_resep', '=', 'buatresep.kd_resep')
            ->join('produkjadi', 'resep.kd_produk', '=', 'produkjadi.kd_produk')
            ->select(DB::raw('DISTINCT resep.kd_resep', 'buatresep.kd_resep', 'produkjadi.*'))
            ->get();

        $dataBahan = BuatResep::join('databahan', 'buatresep.kd_bahan', '=', 'databahan.kd_bahan')
            ->join('resep', 'buatresep.kd_resep', '=', 'resep.kd_resep')
            ->join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('buatresep.id_buatResep', 'databahan.nm_bahan', 'resep.kd_resep', 'satuan.nm_satuan', 'buatResep.kd_bahan', 'buatResep.jumlah')
            ->groupBy('resep.kd_resep', 'buatresep.id_buatResep', 'databahan.kd_bahan', 'databahan.nm_bahan', 'satuan.nm_satuan', 'buatResep.kd_bahan', 'buatResep.jumlah')
            ->get();



        return view('pages.resep.index', ['buatResep' => $buatResep], ['dataBahan' => $dataBahan]);
    }
    // menampilkan satu kd_resep saja jika ada duplikasi
    // $buatResep = $buatResep->unique('kd_resep');

    // menampilkan kd_bahan berdasarkan kd_resep yang sama
    // $dataBahan = $dataBahan->groupBy('kd_resep');

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Resep::class);

        $kode_otomatis = Resep::max('kd_resep');
        $kode_otomatis = (int) substr($kode_otomatis, 3, 3);
        $kode_otomatis = $kode_otomatis + 1;
        $kode_otomatis = "RSP" . sprintf("%03s", $kode_otomatis);

        $dataBahan = DataBahan::join('satuan', 'databahan.kd_satuan', '=', 'satuan.id_satuan')
            ->select('databahan.*', 'satuan.nm_satuan')
            ->get();
        $produkJadi = ProdukJadi::all();
        //join tabel dengan tabel produk dan tabel bahan
        $resep = Resep::all();

        return view(
            'pages.resep.create',
            ['dataBahan' => $dataBahan, 'produkJadi' => $produkJadi, 'resep' => $resep, 'kode_otomatis' => $kode_otomatis],
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
        $this->authorize('create', Resep::class);

        $messages = [
            'kd_produk.required' => 'Pilih produk terlebih dahulu!',
        ];

        $request->validate([
            'kd_produk' => 'required',
        ], $messages);

        if ($request->kd_produk == "0" || $request->kd_produk == null) {
            Alert::warning('Pilih produk', 'Untuk melanjutkan pembuatan resep!');
            return redirect()->route('resep.create');
        }

        // ambil kd_produk dari database
        $kd_produk = Resep::where('kd_produk', $request->kd_produk)->first();

        if ($kd_produk != null) {
            $kode = $kd_produk->kd_produk;
            if ($kode != null || $kode != '') {
                if ($request->kd_produk === $kode && $request->kd_produk != null) {
                    Alert::warning('Data Resep untuk produk ini', 'Sudah ada!');
                    return redirect()->route('resep.create');
                }
            }
        }

        $kd_produk = $request->kd_produk; //HARUS UNIQ
        $kd_bahan = $request->input('kd_bahan');
        $jumlah = $request->input('jumlah');

        if ($kd_bahan == '' || $kd_bahan == null) {
            Alert::warning('Pilih Bahan', 'Agar dapat melanjutkan!');
            return redirect()->route('resep.create');
        } else {
            // membersihkan nama bahan jika tidak ada jumlah
            $kd_bahan = array_intersect_key($kd_bahan, $jumlah);
        }
        $jumlah = array_intersect_key($jumlah, $kd_bahan);
        if ($jumlah[0] == '' || $jumlah[0] == null) {
            Alert::warning('Masukkan Jumlah', 'Agar dapat melanjutkan!');
            return redirect()->route('resep.create');
        }

        // masukkan ke database
        Resep::create([
            'kd_resep' => $request->kd_resep,
            'kd_produk' => $kd_produk,
        ]);

        // agar kd_resep melakukan perulangan sesuai dengan banyaknya kd_bahan
        $kd_resep = $request->kd_resep;
        foreach ($kd_bahan as $key => $value) {
            $data = [
                'kd_resep' => $kd_resep,
                'kd_bahan' => $value,
                'jumlah' => $jumlah[$key],
            ];
            BuatResep::insert($data);
        }


        Alert::success('Data Resep', 'Berhasil ditambahakan!');
        return redirect('/resep');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function show(Resep $resep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function edit(Resep $resep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resep $resep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resep $resep)
    {
        $this->authorize('delete', $resep);

        // hapus data resep
        Resep::destroy($resep->kd_resep);
        Alert::success('Data Resep', 'Berhasil dihapus!');
        return redirect('/resep');
    }
}

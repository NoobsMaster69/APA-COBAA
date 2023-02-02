<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\BuatResep;
use App\Models\DataBahan;
use App\Models\ProdukJadi;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Resep::class);

        $search = $request->search;

        $buatResep = Resep::join('buatresep', 'resep.kd_resep', '=', 'buatresep.kd_resep')
            ->join('produkjadi', 'resep.kd_produk', '=', 'produkjadi.kd_produk')
            ->select(DB::raw('DISTINCT resep.kd_resep, produkjadi.nm_produk, resep.tot_jumlahPakai, resep.tot_hargaPakai, resep.tot_cost, resep.roti_terbuat'))
            ->where('produkJadi.nm_produk', 'LIKE', '%' . $search . '%')
            ->orderBy('resep.created_at', 'desc')
            ->paginate(100)
            ->withQueryString();







        $dataBahan = BuatResep::join('databahan', 'buatresep.kd_bahan', '=', 'databahan.kd_bahan')
            ->join('resep', 'buatresep.kd_resep', '=', 'resep.kd_resep')
            ->select('buatresep.id_buatResep', 'databahan.nm_bahan', 'resep.kd_resep', 'buatResep.kd_bahan', 'buatResep.jumlah')
            ->groupBy('resep.kd_resep', 'buatresep.id_buatResep', 'databahan.kd_bahan', 'databahan.nm_bahan', 'buatResep.kd_bahan', 'buatResep.jumlah')
            ->get();


        // convert dari kg ke gram
        $dataBahan->map(function ($item) {
            $item->jumlah = $item->jumlah * 1000;
            return $item;
        });



        return view(
            'pages.resep.index',
            [
                'buatResep' => $buatResep,
                'dataBahan' => $dataBahan,
                'tittle' => 'Data Resep',
                'judul' => 'Data Resep Produk',
                'menu' => 'Produk',
                'submenu' => 'Data Resep'
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
        $this->authorize('create', Resep::class);

        $kode_otomatis = Resep::max('kd_resep');
        $kode_otomatis = (int) substr($kode_otomatis, 3, 3);
        $kode_otomatis = $kode_otomatis + 1;
        $kode_otomatis = "RSP" . sprintf("%03s", $kode_otomatis);

        $dataBahan = DataBahan::select('databahan.*')
            ->get();
        $produkJadi = ProdukJadi::all();
        //join tabel dengan tabel produk dan tabel bahan
        $resep = Resep::all();

        return view(
            'pages.resep.create',
            [
                'dataBahan' => $dataBahan,
                'produkJadi' => $produkJadi,
                'resep' => $resep,
                'kode_otomatis' => $kode_otomatis,
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Data Resep',
                'menu' => 'Data Resep',
                'submenu' => 'Tambah Data Resep'
            ],
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
        // validasi input jumlah dan kd_bahan yang berupa array tapi jika hanya salah satu yang diisi tidak apa apa


        $messages = [
            'kd_produk.required' => 'Pilih Produk terlebih dahulu',
            'kd_bahan.required' => 'Pilih Bahan terlebih dahulu',
            'jumlah.*.required' => 'Ada Bahan yang belum diisi jumlahnya',
            'jumlah.*.numeric' => 'Jumlah harus berupa angka',
        ];

        $request->validate([
            'kd_produk' => 'required',
            'kd_bahan' => 'required',
        ], $messages);

        $validator = Validator::make($request->all(), [
            'kd_bahan.*' => 'required',
        ], $messages,);


        // dd($request->all());

        $jumlahSebelum = $request->jumlah;

        // validasi jumlah harus angka hanya berlaku jika berada pada kd_bahan yang dipilih
        // $validator = Validator::make($request->all(), [
        //     'jumlah.*' => 'numeric',
        // ], $messages);

        // gunakan fungsi array_filter untuk jumlah
        $jumlah = array_filter($request->jumlah);
        // menyamakan nomer index array dengan nomer index array yang sudah di filter
        $jumlah = array_values($jumlah);

        // langsung masukkan ke dalam $request
        $request->merge(['jumlah' => $jumlah]);

        // jika jumlah dari kd_bahan yang dipilih masih ada yang null maka beri peringatan
        if (count($request->kd_bahan) != count($request->jumlah)) {
            // kembalikan jumlah ke semula
            $request->merge(['jumlah' => $jumlahSebelum]);
            Alert::warning('Peringatan', 'Pastikan sudah memilih bahan dan mengisi jumlah dengan benar!');
            return redirect()->back()->withInput();
        }


        if ($request->has('kd_bahan') && is_array($request->get('kd_bahan'))) {
            foreach ($request->get('kd_bahan') as $key => $value) {
                $validator->sometimes('jumlah.' . $key, 'required|numeric', function ($input) use ($value) {
                    $input->jumlah = array_filter($input->jumlah, function ($value) {
                        return !empty($value);
                    });
                    // return !empty($value);
                });
            }
        } else {
            Alert::warning('Gagal', 'Pilih Bahan terlebih dahulu');
            return redirect()->back()->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $isNumeric = array_map('is_numeric', $jumlah);
        if (!in_array(false, $isNumeric)) {

            // mengambil kd_bahan dari form berupa array
            $kd_bahan = $request->kd_bahan;
            // mengambil jumlah dari form berupa array
            $jumlah = $request->jumlah;
            // mengubah $jumlah menjadi integer
            $jumlahA = array_map('intval', $jumlah);

            $jumlah = array_intersect_key($jumlah, $kd_bahan);
            $kd_bahan = array_intersect_key($kd_bahan, $jumlahA);

            // hilangkan array yang kosong atau null
            $kd_bahan = array_filter($kd_bahan);
            $jumlah = array_filter($jumlahA);

            // mengecek isi dari $jumlah apakah arraynya berupa angka atau bukan

            // jika ada yang bukan angka maka beri peringatan
            // convert $jumlah dari gram ke kg
            $jumlah = array_map(function ($item) {
                return $item / 1000;
            }, $jumlah);
            // menggabungkan kd_bahan dan jumlah menjadi satu array
            $data = array_combine($kd_bahan, $jumlah);

            // mengambil seluruh harga bahan dari tabel data bahan berdasarkan kd_bahan lalu kalikan dengan jumlah masing-masing bahan
            $hargaBahan = DataBahan::select('databahan.*')
                ->whereIn('kd_bahan', $kd_bahan)
                ->get();

            $hargaBahan = $hargaBahan->map(function ($item) use ($data) {
                $item->jumlah = $data[$item->kd_bahan];
                return $item;
            });

            // mencari tot_jumlahPakai dari total jumlah bahan yang digunakan
            $tot_jumlahPakai = $hargaBahan->sum(function ($item) {
                return $item->jumlah;
            });

            // mencari tot_hargaPakai dari total harga bahan yang digunakan
            $tot_hargaPakai = $hargaBahan->sum(function ($item) {
                return $item->jumlah * $item->harga_beli;
            });

            // mengambil berat dari tabel produkJadi berdasarkan kd_produk yang dipilih
            // dd($request->kd_produk);
            $berat = ProdukJadi::select('produkJadi.*')
                ->where('kd_produk', $request->kd_produk)
                ->get();

            $roti_terbuat = $tot_jumlahPakai / $berat[0]->berat;

            // mencari tot_cost dari $tot_hargaPakai dibagi $roti_terbuat
            $tot_cost = $tot_hargaPakai / $roti_terbuat;

            // membulatkan $roti_terbuat ke atas jika lebih dari 0.5 dan ke bawah jika kurang dari 0.5
            $roti_terbuat = round($roti_terbuat, 0, PHP_ROUND_HALF_UP);

            // insert kd_resep, kd_bahan, jumlah, harga_pakai ke tabel buatResep dengan cara looping
            foreach ($data as $key => $value) {
                $buatResep = new BuatResep;
                $buatResep->kd_resep = $request->kd_resep;
                $buatResep->kd_bahan = $key;
                $buatResep->jumlah = $value;
                $buatResep->harga_pakai = $value * $hargaBahan->where('kd_bahan', $key)->first()->harga_beli;
                $buatResep->save();
            }


            // input kd_resep, kd_produk, tot_jumlahPakai, tot_hargaPakai, tot_cost, roti_terbuat ke tabel resep
            $resep = new Resep;
            $resep->kd_resep = $request->kd_resep;
            $resep->kd_produk = $request->kd_produk;
            $resep->tot_jumlahPakai = $tot_jumlahPakai;
            $resep->tot_hargaPakai = $tot_hargaPakai;
            $resep->tot_cost = $tot_cost;
            $resep->roti_terbuat = $roti_terbuat;
            $resep->save();

            Alert::success('Berhasil', 'Data berhasil ditambahkan!');
            return redirect()->route('resep.index');
        } else {
            $request->merge(['jumlah' => $jumlahSebelum]);
            Alert::warning('Peringatan', 'Jumlah harus berupa angka!');
            return redirect()->back()->withInput();
        }
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

        // hapus data resep di tabel resep  
        Resep::where('kd_resep', $resep->kd_resep)->delete();
        // hapus data resep di tabel buatResep
        BuatResep::where('kd_resep', $resep->kd_resep)->delete();
        Alert::success('Data Resep', 'Berhasil dihapus!');
        return redirect('/resep');
    }
}

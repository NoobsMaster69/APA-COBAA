<?php

namespace App\Http\Controllers;

use App\Models\BahanKeluar;
use Illuminate\Http\Request;
// gunakan model dari produkjadi
use App\Models\Produkjadi;
use App\Models\DataBahan;
use App\Models\ProdukKeluar;
use App\Models\ProdukMasuk;
use App\Models\pengirimanProduk;
use App\Models\Karyawan;
use App\Models\Sopir;
use Illuminate\Support\Facades\DB;

// 

class DashboardController extends Controller
{
    public function index()
    {
        // count produkjadi
        $produkjadi = Produkjadi::count();
        $databahan = DataBahan::count();
        $karyawan = Karyawan::count();
        $pengirimanproduk = pengirimanProduk::count();

        // sum field stok dataBahan dengan number_format
        $stokBahan = number_format(DataBahan::sum('stok'));

        // menghitung sum field total dari tabel produk jadi pada bulan ini
        $produkKeluar_lap_bulanIni = ProdukKeluar::whereMonth('tgl_keluar', date('m'))->sum('total');

        // menghitung sum field total dari tabel produkMasuk pada bulan ini
        $produkMasuk_lap_bulanIni = ProdukMasuk::whereMonth('tgl_produksi', date('m'))->sum('total');

        $keuntungan = $produkKeluar_lap_bulanIni - $produkMasuk_lap_bulanIni;
        // buat persentase keuntungan
        $persentaseKeuntungan = 0;
        if ($produkMasuk_lap_bulanIni > 0) {
            $persentaseKeuntungan = ($keuntungan / $produkKeluar_lap_bulanIni) * 100;
        }

        // sum fiels total bahanKeluar
        $bahanKeluar = BahanKeluar::sum('total');


        // jadikan persentase keuntungan menjadi 2 angka dibelakang koma
        $persentaseKeuntungan = number_format($persentaseKeuntungan, 2);

        // count fieldjumlah produkKeluar
        $produkTerjual = ProdukKeluar::whereMonth('tgl_keluar', date('m'))->sum('jumlah');
        $produkStok = Produkjadi::sum('stok');

        $totalTerjual = $produkTerjual;

        // dd($produkStok);

        // jadikan persentase totalTerjual
        $persentaseTerjual = 0;
        if ($produkStok > 0) {
            $persentaseTerjual = ($totalTerjual / $produkStok) * 100;
        }

        $persentaseTerjual = number_format($persentaseTerjual, 2);


        // menghitung sum field total dari tabel produk jadi pada bulan lalu
        // $produkKeluar_lap_bulanLalu = ProdukKeluar::whereMonth('tgl_keluar', date('m') - 1)->sum('total');

        // mengambil data dari field total di tabel produkKeluar berdasarkan setiap bulan lalu akan ditampilkan menggunakan chart
        $produkKeluar_lap_setiapBulan = ProdukKeluar::select(DB::raw("sum(total) as total"), DB::raw("monthname(tgl_keluar) as month"))
            ->whereYear('tgl_keluar', date('Y'))
            ->groupBy(DB::raw('Month(tgl_keluar)'), DB::raw('monthname(tgl_keluar)'))
            ->pluck('total', 'month');

        $jumlah = $produkKeluar_lap_setiapBulan->values();
        $labels = $produkKeluar_lap_setiapBulan->keys();

        // mengubah isi dari array $labels agar bulan berbahasa indonesia
        // lakukan jika ada data 
        if ($labels->count() > 0) {
            $labels = $labels->map(function ($item) {
                switch ($item) {
                    case 'January':
                        return 'Januari';
                        break;
                    case 'February':
                        return 'Februari';
                        break;
                    case 'March':
                        return 'Maret';
                        break;
                    case 'April':
                        return 'April';
                        break;
                    case 'May':
                        return 'Mei';
                        break;
                    case 'June':
                        return 'Juni';
                        break;
                    case 'July':
                        return 'Juli';
                        break;
                    case 'August':
                        return 'Agustus';
                        break;
                    case 'September':
                        return 'September';
                        break;
                    case 'October':
                        return 'Oktober';
                        break;
                    case 'November':
                        return 'November';
                        break;
                    case 'December':
                        return 'Desember';
                        break;
                }
            });
        }

        // mengambil data dari field total di tabel produkMasuk berdasarkan setiap bulan lalu akan ditampilkan menggunakan chart
        $produkMasuk_lap_setiapBulan = ProdukMasuk::select(DB::raw("sum(total) as total"), DB::raw("monthname(tgl_produksi) as month"))
            ->whereYear('tgl_produksi', date('Y'))
            ->groupBy(DB::raw('Month(tgl_produksi)'), DB::raw('monthname(tgl_produksi)'))
            ->pluck('total', 'month');

        $jumlahMasuk = $produkMasuk_lap_setiapBulan->values();
        $labelsMasuk = $produkMasuk_lap_setiapBulan->keys();

        // dd($labelsMasuk, $jumlahMasuk);

        // mengubah isi dari array $labelsMasuk agar bulan berbahasa indonesia
        // lakukan jika ada data
        if ($labelsMasuk->count() > 0) {
            $labelsMasuk = $labelsMasuk->map(function ($item) {
                switch ($item) {
                    case 'January':
                        return 'Januari';
                        break;
                    case 'February':
                        return 'Februari';
                        break;
                    case 'March':
                        return 'Maret';
                        break;
                    case 'April':
                        return 'April';
                        break;
                    case 'May':
                        return 'Mei';
                        break;
                    case 'June':
                        return 'Juni';
                        break;
                    case 'July':
                        return 'Juli';
                        break;
                    case 'August':
                        return 'Agustus';
                        break;
                    case 'September':
                        return 'September';
                        break;
                    case 'October':
                        return 'Oktober';
                        break;
                    case 'November':
                        return 'November';
                        break;
                    case 'December':
                        return 'Desember';
                        break;
                }
            });
        }

        // melakukan sum total group by kd_produk pada tabel produkKeluar
        $produkKeluar = ProdukKeluar::select(DB::raw("sum(jumlah) as jumlah"), DB::raw("kd_produk"))
            ->join('produkJadi', 'produkJadi.kd_produk', '=', 'produkKeluar.kd_produk')
            ->select('produkJadi.nm_produk', 'produkKeluar.kd_produk', DB::raw("sum(jumlah) as jumlah"))
            ->whereYear('tgl_keluar', date('Y'))
            ->groupBy('kd_produk', 'nm_produk')
            ->orderBy('jumlah', 'desc')
            ->take(3)
            ->get();



        $produkKeluar_lap_pie = $produkKeluar->pluck('jumlah');
        $produkKeluar_lap_pie_label = $produkKeluar->pluck('nm_produk');

        // dd($produkKeluar_lap_pie_label, $produkKeluar_lap_pie);

        // ambil 3 teratas dari id_lokasi di tabel pengirimanProduk yang paling banyak jumlah rotinya di tabel produkKeluar dihubungkan dengan id_produkKeluar
        $lokasiTerbanyak = pengirimanProduk::select(DB::raw('sum(jumlah) as jumlah'), DB::raw('id_lokasi'), DB::raw('tempat'))
            ->join('lokasiPengiriman', 'pengirimanProduk.id_lokasi', '=', 'lokasiPengiriman.id_lokasiPengiriman')
            ->join('produkKeluar', 'produkKeluar.id_produkKeluar', '=', 'pengirimanProduk.id_produkKeluar')
            ->groupBy('id_lokasi', 'tempat')
            ->orderBy('jumlah', 'desc')
            ->take(3)
            ->get();

        $labelsLokasi = $lokasiTerbanyak->pluck('tempat')->toArray();
        $jumlahLokasi = $lokasiTerbanyak->pluck('jumlah')->toArray();


        // ambil sopir teratas berdasarkan berapa kali mengirimkan produk di tabel pengirimanProduk
        $sopirTerbanyak = Sopir::join('pengirimanProduk', 'sopir.kd_sopir', '=', 'pengirimanProduk.kd_sopir')
            ->join('produkKeluar', 'produkKeluar.id_produkKeluar', '=', 'pengirimanProduk.id_produkKeluar')
            ->select('sopir.nm_sopir', 'sopir.kd_sopir', 'sopir.foto', DB::raw('count(pengirimanProduk.kd_sopir) as jumlah'), DB::raw('sum(produkKeluar.jumlah) as jumlah_produk'))
            ->groupBy('sopir.nm_sopir', 'sopir.kd_sopir', 'sopir.foto')
            ->orderByRaw('jumlah_produk DESC, jumlah DESC')
            ->get();



        // mengirim data produkjadi ke view index
        return view('pages.dashboard.index', ['produkJadi' => $produkjadi, 'dataBahan' => $databahan, 'karyawan' => $karyawan, 'pengirimanProduk' => $pengirimanproduk, 'produkKeluar_lap_bulanIni' => $produkKeluar_lap_bulanIni, 'produkMasuk_lap_bulanIni' => $produkMasuk_lap_bulanIni, 'produkKeluar_lap_setiapBulan' => $produkKeluar_lap_setiapBulan, 'labels' => $labels, 'jumlah' => $jumlah, 'produkMasuk_lap_setiapBulan' => $produkMasuk_lap_setiapBulan, 'labelsMasuk' => $labelsMasuk, 'jumlahMasuk' => $jumlahMasuk, 'produkKeluar_lap_pie' => $produkKeluar_lap_pie, 'produkKeluar_lap_pie_label' => $produkKeluar_lap_pie_label, 'keuntungan' => $keuntungan, 'persentaseKeuntungan' => $persentaseKeuntungan, 'produkTerjual' => $produkTerjual, 'persentaseTerjual' => $persentaseTerjual, 'bahanKeluar' => $bahanKeluar, 'labelsLokasi' => $labelsLokasi, 'jumlahLokasi' => $jumlahLokasi, 'sopirTerbanyak' => $sopirTerbanyak, 'produkStok' => $produkStok, 'stokBahan' => $stokBahan]);
    }
}

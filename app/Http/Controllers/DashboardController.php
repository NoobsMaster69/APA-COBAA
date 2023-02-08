<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// gunakan model dari produkjadi
use App\Models\Produkjadi;
use App\Models\DataBahan;
use App\Models\ProdukKeluar;
use App\Models\ProdukMasuk;
use App\Models\pengirimanProduk;
use App\Models\Karyawan;
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

        // menghitung sum field total dari tabel produk jadi pada bulan ini
        $produkKeluar_lap_bulanIni = ProdukKeluar::whereMonth('tgl_keluar', date('m'))->sum('total');

        // menghitung sum field total dari tabel produkMasuk pada bulan ini
        $produkMasuk_lap_bulanIni = ProdukMasuk::whereMonth('tgl_produksi', date('m'))->sum('total');

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





        // mengirim data produkjadi ke view index
        return view('pages.dashboard.index', ['produkJadi' => $produkjadi, 'dataBahan' => $databahan, 'karyawan' => $karyawan, 'pengirimanProduk' => $pengirimanproduk, 'produkKeluar_lap_bulanIni' => $produkKeluar_lap_bulanIni, 'produkMasuk_lap_bulanIni' => $produkMasuk_lap_bulanIni, 'produkKeluar_lap_setiapBulan' => $produkKeluar_lap_setiapBulan, 'labels' => $labels, 'jumlah' => $jumlah, 'produkMasuk_lap_setiapBulan' => $produkMasuk_lap_setiapBulan, 'labelsMasuk' => $labelsMasuk, 'jumlahMasuk' => $jumlahMasuk, 'produkKeluar_lap_pie' => $produkKeluar_lap_pie, 'produkKeluar_lap_pie_label' => $produkKeluar_lap_pie_label]);
    }
}

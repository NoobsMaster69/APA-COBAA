<?php

namespace App\Http\Controllers;

use App\Models\Kwitansi;
use App\Models\PosOrder;
use App\Models\PosOrderDetail;
use App\Models\PosTemp;
use App\Models\ProdukJadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class PosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $produk = ProdukJadi::where('kd_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('nm_produk', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(9)->withQueryString();

        $temp = PosTemp::join('produkJadi', 'pos_temps.produk_id', '=', 'produkJadi.kd_produk')
            ->select('pos_temps.*', 'produkJadi.nm_produk', 'produkJadi.stok', 'produkJadi.harga_jual')->get();

        $sum = DB::table('pos_temps')->sum('harga');

        $kwitansi = Kwitansi::join('pos_orders', 'kwitansi.order_id', '=', 'pos_orders.id')
            ->select('kwitansi.*', 'pos_orders.*')->where('kwitansi.status', '=', 1)->first();

        return view(
            'pages.pos.index',
            compact('produk', 'temp', 'sum', 'kwitansi'),
            [
                'tittle' => 'POS System',
                'judul' => 'Point of Sale System'
            ]
        );
    }


    public function temp_create(Request $request)
    {

        $produk = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
        $sisaStok = $produk->stok - $request->jumlah; // mencari sisa stok

        // cek ketersediaan stok
        if ($sisaStok < 0) {
            Alert::warning('Stok tidak mencukupi!', 'Silahkan tambahkan stok terlebih dahulu');
            return back();
        } else {
            $dataTemp = PosTemp::where('produk_id', $request->kd_produk)->first();

            // cek apakah data yg di tambahkan itu sama
            if (!empty($dataTemp) || $dataTemp == !null) {
                $produk = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
                $sisaStok = $produk->stok - ($dataTemp->jumlah + $request->jumlah);

                // dd($sisaStok, $dataTemp->jumlah, $request->jumlah, $produk->stok);

                // cek ketersediaan stok
                if ($sisaStok < 0) {
                    Alert::warning('Stok tidak mencukupi!', 'Silahkan tambahkan stok terlebih dahulu');
                    return back();
                } else {
                    // menambahkan jumlah produk yg lama
                    $dataTemp->jumlah = $dataTemp->jumlah + $request->jumlah;

                    // mengupdate subharga
                    $produk = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
                    $dataTemp->harga = $produk->harga_jual * $dataTemp->jumlah;

                    $dataTemp->update();
                    return back();
                }
            } else {

                // masukkan ke tabel sementara
                $temp = new PosTemp();
                $temp->produk_id = $request->kd_produk;
                $temp->jumlah = $request->jumlah;

                $produk = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
                $temp->harga = $produk->harga_jual * $request->jumlah;

                $temp->save();
                return back();
            }
        }
    }


    public function temp_update(Request $request, $id)
    {
        $produk = ProdukJadi::find($request->kd_produk);
        $sisaStok = $produk->stok - $request->jumlah; // mencari sisa stok

        // cek ketersediaan stok
        if ($sisaStok < 0) {
            Alert::warning('Stok tidak mencukupi!', 'Silahkan tambahkan stok terlebih dahulu');
            return back();
        } else {

            $dataTemp = PosTemp::find($id);

            $dataTemp->jumlah = $request->jumlah;
            $dataTemp->harga = $produk->harga_jual * $request->jumlah;

            $dataTemp->update();
            return back();
        }
    }


    public function temp_delete($id)
    {
        $dataTemp = PosTemp::find($id);
        $dataTemp->delete();
        return back();
    }


    public function temp_delete_all()
    {
        $dataTemp = PosTemp::all();
        foreach ($dataTemp as $temp) {
            $temp->delete();
        }
        return back();
    }


    public function order_create(Request $request)
    {

        if ($request->total) {

            // masukkan data ke table order
            $order = new PosOrder();

            // membuat nomor referensi
            $kode = PosOrder::max('no_referensi');
            $kode = (int) substr($kode, 3, 3);
            $kode = $kode + 1;
            $no_ref = "REF" . sprintf("%03s", $kode);

            // cek pembayaran
            if ($request->bayar <= $request->total) {
                Alert::warning('Pemabayaran gagal!', 'Harap bayar sesuai total pesanan');
                return back();
            } else {
                $order->no_referensi = $no_ref;
                $order->total = $request->total;
                $order->bayar = $request->bayar;
                $order->save();
            }

            $dataTemp = PosTemp::all();

            // masukkan juga data ke table order detail
            foreach ($dataTemp as $temp) {
                $detail = new PosOrderDetail();
                $detail->order_id = $order->id;
                $detail->produk_id = $temp->produk_id;
                $detail->jumlah = $temp->jumlah;
                $detail->harga = $temp->harga;
                $detail->save();

                // hapus data di tabel sementara
                $temp->delete();

                // update stok di table produk
                $produk = ProdukJadi::find($temp->produk_id);
                $produk->stok = $produk->stok - $temp->jumlah;
                $produk->update();
            }

            // membuat nomor Kwitansi
            $kode = Kwitansi::max('no_kwitansi');
            $kode = (int) substr($kode, 5, 3);
            $kode = $kode + 1;
            $no_kwi = "ORDER" . sprintf("%03s", $kode);

            // masukkan juga data ke tabel kwitansi
            $kwitansi = new Kwitansi();
            $kwitansi->no_kwitansi = $no_kwi;
            $kwitansi->order_id = $order->id;
            $kwitansi->save();

            Alert::success('Pesanan berhasil!', 'Silahkan cetak nota pembayaran');
            return back();
        } else {
            Alert::warning('Pemabayaran gagal!', 'Harap memilih produk terlebih dahulu');
            return back();
        }
    }

    public function print()
    {
        $kwitansi = Kwitansi::join('pos_orders', 'kwitansi.order_id', '=', 'pos_orders.id')
            ->select('kwitansi.*', 'pos_orders.*')->where('kwitansi.status', '=', 1)->first();

        return view('pages.pos.cetak-kwitansi', compact('kwitansi'));
    }

    public function transaksi()
    {
        $data = Kwitansi::join('pos_orders', 'kwitansi.order_id', '=', 'pos_orders.id')
            ->select('kwitansi.*', 'pos_orders.*')->where('kwitansi.status', '=', 2)->paginate(8);

        return view(
            'pages.pos.riwayat-transaksi',
            compact('data'),
            [
                'tittle' => 'Riwayat Transaksi',
                'judul' => 'Riwayat Transaksi',
                'menu' => 'Riwayat Transaksi',
            ]
        );
    }
}

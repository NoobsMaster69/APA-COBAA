<?php

namespace App\Http\Controllers;

use App\Models\PosOrder;
use App\Models\PosOrderDetail;
use App\Models\PosTemp;
use App\Models\ProdukJadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $produk = ProdukJadi::all();

        $temp = PosTemp::join('produkJadi', 'pos_temps.produk_id', '=', 'produkJadi.kd_produk')
            ->select('pos_temps.*', 'produkJadi.nm_produk', 'produkJadi.stok', 'produkJadi.harga_jual')->get();

        $sum = DB::table('pos_temps')->sum('harga');


        return view(
            'pages.pos.index',
            compact('produk', 'temp', 'sum'),
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

        // cek ketersediaan stok, stok produk harus tersisa min 10
        if ($sisaStok < 10) {
            dd('stok tidak ada');
        } else {
            $dataTemp = PosTemp::where('produk_id', $request->kd_produk)->first();

            // cek apakah data yg di tambahkan itu sama
            if (!empty($dataTemp) || $dataTemp == !null) {

                // menambahkan jumlah produk yg lama
                $dataTemp->jumlah = $dataTemp->jumlah + $request->jumlah;

                // mengupdate subharga
                $produk = ProdukJadi::where('kd_produk', $request->kd_produk)->first();
                $dataTemp->harga = $produk->harga_jual * $dataTemp->jumlah;

                $dataTemp->update();
                return back();
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

        // cek ketersediaan stok, stok produk harus tersisa min 10
        if ($sisaStok < 10) {
            dd('stok tidak ada');
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
            $order->tanggal = date('Y-m-d');
            $order->keterangan = 'xxx';
            $order->total = $request->total;
            $order->save();

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

            return back();
        } else {
            dd('harap memilih produk');
        }
    }
}

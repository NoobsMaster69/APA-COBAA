<?php

namespace App\Http\Controllers;

use App\Models\BahanKeluar;
use App\Models\DataBahan;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BahanKeluarController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', bahanKeluar::class);

        $search = $request->search;
        // menyatukan search dengan join tabel
        $bahanKeluar = BahanKeluar::join('dataBahan', 'bahanKeluar.kd_bahan', '=', 'dataBahan.kd_bahan')
            ->select('bahanKeluar.*', 'dataBahan.nm_bahan', 'dataBahan.harga_beli')
            ->where('bahanKeluar.kd_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanKeluar.nm_bahan', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanKeluar.tgl_keluar', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanKeluar.jumlah', 'LIKE', '%' . $search . '%')
            ->orWhere('bahanKeluar.ket', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(2)->withQueryString();

        // mengirim tittle dan judul ke view
        return view(
            'pages.bahanKeluar.index',
            ['bahanKeluar' => $bahanKeluar],
            [
                'tittle' => 'Pemakaian Bahan',
                'judul' => 'Pemakaian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Pemakaian Bahan'
            ]
        );
    }


    public function create()
    {
        $this->authorize('create', bahanKeluar::class);

        // join dengan tabel satuan
        $dataBahan = DataBahan::select('databahan.*')
            ->get();

        return view(
            'pages.bahanKeluar.create',
            ['dataBahan' => $dataBahan],
            [
                'tittle' => 'Pemakaian Bahan',
                'judul' => 'Pemakaian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Pemakaian Bahan'
            ]
        );
    }


    public function store(Request $request)
    {
        $this->authorize('create', bahanKeluar::class);

        // mengubah nama validasi
        $messages = [
            'kd_bahan.required' => 'Kode Bahan tidak boleh kosong',
            'nm_bahan.required' => 'Nama Bahan tidak boleh kosong',
            'tgl_keluar.required' => 'Tanggal Keluar tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'ket.required' => 'Keterangan tidak boleh kosong',
        ];

        $request->validate([
            'kd_bahan' => 'required',
            'nm_bahan' => 'required',
            'tgl_keluar' => 'required',
            'jumlah' => 'required|numeric',
            'ket' => 'required',
        ], $messages);

        // stok bahan berkurang
        $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();

        // ubah jumlah dari kilogram ke gram
        $jumlah = $request->jumlah / 1000;
        // update stok bahan
        if ($stok->stok < $jumlah) {
            Alert::warning('Stok tidak mencukupi', 'Silahkan tambahkan stok terlebih dahulu!');
            return redirect('bahanKeluar');
        } else {
            $stok->stok = $stok->stok - $jumlah;
            $stok->save();
        }
        // merubah harga_beli dan jumlah menjadi integer
        $harga_beli = (int) $request->harga_beli;
        $jumlah = (int) $jumlah;

        $total = $harga_beli * $jumlah;

        // mengubah format tgl_masuk dari text ke date
        $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar));


        // insert data ke table bahan keluar
        BahanKeluar::create([
            'kd_bahan' => $request->kd_bahan,
            'nm_bahan' => $request->nm_bahan,
            'tgl_keluar' => $tgl_keluar,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'ket' => $request->ket,
        ]);

        // alihkan halaman ke halaman bahan keluar
        Alert::success('Data Pemakaian Bahan', 'Berhasil Ditambahkan!');
        return redirect('/bahanKeluar');
    }


    public function show(bahanKeluar $bahanKeluar)
    {
        //
    }


    public function edit(bahanKeluar $bahanKeluar)
    {
        $this->authorize('update', $bahanKeluar);

        // join tabel satuan
        $dataBahan = DataBahan::select('databahan.*')
            ->where('kd_bahan', $bahanKeluar->kd_bahan)
            ->first();

        return view(
            'pages.bahanKeluar.edit',
            compact('bahanKeluar', 'dataBahan'),
            [
                'tittle' => 'Edit Data Pemakaian Bahan',
                'judul' => 'Edit Data Pemakaian Bahan',
                'menu' => 'Bahan Baku',
                'submenu' => 'Edit Data'
            ]
        );
    }


    public function update(Request $request, bahanKeluar $bahanKeluar)
    {
        $this->authorize('update', $bahanKeluar);

        // cek apakah bahannya di ubah
        if ($request->has('kd_bahan')) {
            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Pilih Kode Bahan terlebih dahulu',
                'tgl_keluar.required' => 'Tanggal Keluar tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
                'ket.required' => 'Keterangan tidak boleh kosong',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'tgl_keluar' => 'required',
                'jumlah' => 'required|numeric',
                'ket' => 'required',
            ], $messages);

            // ubah jumlah dari kilogram ke gram
            $jumlah = $bahanKeluar->jumlah / 1000;
            // mengembalikan stok bahan yg lama
            $stok = DataBahan::where('kd_bahan', $bahanKeluar->kd_bahan)->first();
            $stok->stok = $stok->stok + $jumlah;
            $stok->save();


            if ($stok->stok < $jumlah) {
                Alert::warning('Stok tidak mencukupi', 'Silahkan tambahkan stok terlebih dahulu!');
                return redirect('bahanKeluar');
            } else {
                $stok->stok = $stok->stok - $jumlah;
                $stok->save();
            }

            // merubah harga_beli dan jumlah menjadi integer
            $harga_beli = (int) $stok->harga_beli;
            $jumlah = (int) $jumlah;


            $input = $request->all();

            // mengubah format tgl_masuk dari text ke date
            $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar));

            // mencari total harga
            $total = $harga_beli * $jumlah;
            $input['total'] = $total;
            $input['tgl_keluar'] = $tgl_keluar;

            $bahanKeluar->update($input);

            Alert::success('Data Pemakaian Bahan', 'Berhasil diubah!');
            return redirect('/bahanKeluar');
        } else {
            // mengubah nama validasi
            $messages = [
                'kd_bahan.required' => 'Pilih Kode Bahan terlebih dahulu',
                'tgl_keluar.required' => 'Tanggal Keluar tidak boleh kosong',
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
                'ket.required' => 'Keterangan tidak boleh kosong',
            ];

            $request->validate([
                'kd_bahan' => 'required',
                'tgl_keluar' => 'required',
                'jumlah' => 'required|numeric',
                'ket' => 'required',
            ], $messages);

            // cek apakah jumlah diubah
            if ($request->has('jumlah')) {

                // update stok bahan
                $stok = DataBahan::where('kd_bahan', $request->kd_bahan)->first();
                if ($stok->stok < $request->jumlah) {
                    Alert::warning('Stok tidak mencukupi', 'Silahkan tambahkan stok terlebih dahulu!');
                    return redirect('bahanKeluar');
                } else {
                    $stok->stok = $stok->stok - $request->jumlah;
                    $stok->save();
                }

                // merubah harga_beli dan jumlah menjadi integer
                $harga_beli = (int) $stok->harga_beli;
                $jumlah = (int) $request->jumlah;

                $input = $request->all();

                // mengubah format tgl_masuk dari text ke date
                $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar));

                // mencari total harga
                $total = $harga_beli * $jumlah;
                $input['total'] = $total;
                $input['tgl_keluar'] = $tgl_keluar;

                $bahanKeluar->update($input);

                Alert::success('Data Pemakaian Bahan', 'Berhasil diubah!');
                return redirect('/bahanKeluar');
            } else {
                $input = $request->all();
                // mengubah format tgl_masuk dari text ke date
                $tgl_keluar = date('Y-m-d', strtotime($request->tgl_keluar));
                $input['tgl_keluar'] = $tgl_keluar;

                $bahanKeluar->update($input);

                Alert::success('Data Pemakaian Bahan', 'Berhasil diubah!');
                return redirect('/bahanKeluar');
            }
        }
    }


    public function destroy(bahanKeluar $bahanKeluar)
    {
        $this->authorize('delete', $bahanKeluar);

        // update stok bahan
        $stok = DataBahan::where('kd_bahan', $bahanKeluar->kd_bahan)->first();
        $stok->stok = $stok->stok + $bahanKeluar->jumlah;
        $stok->save();

        $bahanKeluar->delete();
        Alert::success('Data Pemakaian Bahan', 'Berhasil dihapus!');
        return redirect('/bahanKeluar');
    }
}

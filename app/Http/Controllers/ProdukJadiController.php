<?php

namespace App\Http\Controllers;

use App\Models\ProdukJadi;
use Illuminate\Http\Request;
use App\Models\Satuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class ProdukJadiController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', ProdukJadi::class);

        $search = $request->search;

        // menyatukan search dengan join tabel
        $produkJadi = ProdukJadi::join('satuan', 'produkjadi.kd_satuan', '=', 'satuan.id_satuan')
            ->select('produkjadi.*', 'satuan.nm_satuan')
            ->where('produkjadi.kd_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('produkjadi.nm_produk', 'LIKE', '%' . $search . '%')
            ->orWhere('satuan.nm_satuan', 'LIKE', '%' . $search . '%')
            ->orWhere('produkjadi.harga_jual', 'LIKE', '%' . $search . '%')
            ->orWhere('produkjadi.stok', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(8)->withQueryString();

        // mengirim tittle dan judul ke view
        return view('pages.produkJadi.index', ['produkJadi' => $produkJadi], ['tittle' => 'Data Produk', 'judul' => 'Data Produk', 'menu' => 'Produk', 'submenu' => 'Data Produk']);
    }

    public function create()
    {
        $this->authorize('create', ProdukJadi::class);

        $kode = ProdukJadi::max('kd_produk');
        $kode = (int) substr($kode, 4, 4);
        $kode = $kode + 1;
        $kode_otomatis = "PRDK" . sprintf("%03s", $kode);

        $satuan = Satuan::all();

        return view(
            'pages.produkJadi.create',
            ['kode_otomatis' => $kode_otomatis, 'satuan' => $satuan],
            ['tittle' => 'Tambah Data', 'judul' => 'Tambah Data Produk', 'menu' => 'Data Produk', 'submenu' => 'Tambah Data']
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', ProdukJadi::class);

        // mengubah nama validasi
        $messages = [
            'kd_produk.required' => 'Kode Produk tidak boleh kosong',
            'nm_produk.required' => 'Nama Produk tidak boleh kosong',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'kd_satuan.required' => 'Pilih nama satuan terlebih dahulu',
            'harga_jual.required' => 'Harga Jual tidak boleh kosong',
            'harga_jual.integer' => 'Harga Jual harus berupa angka',
            'modal.required' => 'Modal tidak boleh kosong',
            'modal.integer' => 'Modal harus berupa angka',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'ket.min' => 'Keterangan minimal 3 karakter',
            'foto.required' => 'Foto tidak boleh kosong',
            'foto.image' => 'File yang anda pilih bukan foto atau gambar',
            'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
            'foto.dimensions' => 'Foto harus memiliki ratio 1:1 atau berbentuk persegi'
        ];

        $request->validate([
            'kd_produk' => 'required',
            'nm_produk' => 'required',
            'stok' => 'required|integer',
            'kd_satuan' => 'required',
            'modal' => 'required|integer',
            'harga_jual' => 'required|integer',
            'ket' => 'required|min:3',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|dimensions:ratio=1/1'
        ], $messages);

        $input = $request->all();

        if ($image = $request->file('foto')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension() . ".webp";
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(150, 150);
            $image_resize->save(public_path($destinationPath . $profileImage));
            $input['foto'] = "$profileImage";
        }

        ProdukJadi::create($input);

        Alert::success('Data Produk', 'Berhasil Ditambahkan!');
        return redirect('/produkJadi');
    }
    // public function tmpUpload(Request $request)
    // {
    //     if ($image = $request->file('foto')) {
    //         $destinationPath = 'images/';
    //         $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension() . ".webp";
    //         $image_resize = Image::make($image->getRealPath());
    //         $image_resize->resize(150, 150);
    //         $image_resize->save(public_path($destinationPath . $profileImage));
    //         $input['foto'] = "$profileImage";
    //     }
    // }

    public function show(ProdukJadi $produkJadi)
    {
        //
    }


    public function edit(ProdukJadi $produkJadi)
    {
        $this->authorize('update', $produkJadi);

        $produkJadi = DB::table('produkjadi')->join('satuan', 'produkjadi.kd_satuan', '=', 'satuan.id_satuan')->select('produkjadi.*', 'satuan.nm_satuan')->where('kd_produk', $produkJadi->kd_produk)->first();

        // dd($produkJadi->foto);

        $satuan = Satuan::all();
        return view(
            'pages.ProdukJadi.edit',
            compact('produkJadi', 'satuan'),
            ['tittle' => 'Edit Data', 'judul' => 'Edit Data Produk', 'menu' => 'Data Produk', 'submenu' => 'Edit Data']
        );
    }

    public function update(Request $request, ProdukJadi $produkJadi)
    {
        $this->authorize('update', $produkJadi);

        // cek apakah user mengganti foto atau tidak
        if ($request->has('foto')) {
            $produkJadi = ProdukJadi::find($produkJadi->kd_produk);
            File::delete('images/' . $produkJadi->foto);

            // mengubah nama validasi
            $messages = [
                'kd_produk.required' => 'Kode Produk tidak boleh kosong',
                'nm_produk.required' => 'Nama Produk tidak boleh kosong',
                'stok.required' => 'Stok tidak boleh kosong',
                'stok.integer' => 'Stok harus berupa angka',
                'kd_satuan.required' => 'Pilih nama satuan terlebih dahulu',
                'modal.required' => 'Modal tidak boleh kosong',
                'modal.integer' => 'Modal harus berupa angka',
                'harga_jual.required' => 'Harga Jual tidak boleh kosong',
                'harga_jual.integer' => 'Harga Jual harus berupa angka',
                'ket.required' => 'Keterangan tidak boleh kosong',
                'ket.min' => 'Keterangan minimal 3 karakter',
                'foto.required' => 'Foto tidak boleh kosong',
                'foto.image' => 'File yang anda pilih bukan foto atau gambar',
                'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
                'foto.dimensions' => 'Foto harus memiliki ratio 1:1 atau berbentuk persegi'
            ];

            $rules = [
                'kd_produk' => 'required',
                'nm_produk' => 'required',
                'stok' => 'required|integer',
                'kd_satuan' => 'required',
                'modal' => 'required|integer',
                'harga_jual' => 'required|integer',
                'ket' => 'required|min:3',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|dimensions:ratio=1/1'
            ];

            $input = $request->validate($rules, $messages);

            // if ($image = $request->file('foto')) {
            //     $destinationPath = 'images/';
            //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension() . ".webp";
            //     $image->move($destinationPath, $profileImage);
            //     $input['foto'] = "$profileImage";
            // }
            if ($image = $request->file('foto')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension() . ".webp";
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(150, 150);
                $image_resize->save(public_path($destinationPath . $profileImage));
                $input['foto'] = "$profileImage";
            }


            $produkJadi->update($input);

            Alert::success('Data Produk', 'Berhasil Diubah!');
            return redirect('/produkJadi');
        } else {
            // mengubah nama validasi
            $messages = [
                'kd_produk.required' => 'Kode Produk tidak boleh kosong',
                'nm_produk.required' => 'Nama Produk tidak boleh kosong',
                'stok.required' => 'Stok tidak boleh kosong',
                'stok.integer' => 'Stok harus berupa angka',
                'kd_satuan.required' => 'Pilih nama satuan terlebih dahulu',
                'modal.required' => 'Modal tidak boleh kosong',
                'modal.integer' => 'Modal harus berupa angka',
                'harga_jual.required' => 'Harga Jual tidak boleh kosong',
                'harga_jual.integer' => 'Harga Jual harus berupa angka',
                'ket.required' => 'Keterangan tidak boleh kosong',
                'ket.min' => 'Keterangan minimal 3 karakter',
            ];

            $rules = [
                'kd_produk' => 'required',
                'nm_produk' => 'required',
                'stok' => 'required|integer',
                'kd_satuan' => 'required',
                'modal' => 'required|integer',
                'harga_jual' => 'required|integer',
                'ket' => 'required|min:3',
            ];

            $input = $request->validate($rules, $messages);

            $produkJadi->update($input);
            Alert::success('Data Produk', 'Berhasil diubah!');
            return redirect('/produkJadi');
        }
    }

    public function destroy(ProdukJadi $produkJadi)
    {
        $this->authorize('delete', $produkJadi);

        File::delete('images/' . $produkJadi->foto);
        $produkJadi->delete();
        Alert::success('Data Produk', 'Berhasil dihapus!');
        return redirect('produkJadi');
    }
}

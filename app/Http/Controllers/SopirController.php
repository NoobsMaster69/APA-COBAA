<?php

namespace App\Http\Controllers;

use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class SopirController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Sopir::class);

        $search = $request->search;

        $sopir = Sopir::where('nm_sopir', 'LIKE', '%' . $search . '%')
            ->orWhere('no_ktp', 'LIKE', '%' . $search . '%')
            ->orWhere('jenis_kelamin', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(5)->withQueryString();

        // $sopir = Sopir::paginate(3);

        // mengirim tittle dan judul ke view
        return view(
            'pages.sopir.index',
            [
                'sopir' => $sopir,
                'tittle' => 'Data Sopir',
                'judul' => 'Data Sopir',
                'menu' => 'Data Sopir',
                'submenu' => 'Data Sopir'
            ]
        );
    }

    public function create()
    {
        $this->authorize('create', Sopir::class);

        $kode = Sopir::max('kd_sopir');
        $kode = (int) substr($kode, 4, 4);
        $kode = $kode + 1;
        $kode_otomatis = "SPR" . sprintf("%03s", $kode);

        return view(
            'pages.sopir.create',
            [
                'kode_otomatis' => $kode_otomatis,
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Data Sopir',
                'menu' => 'Data Sopir',
                'submenu' => 'Tambah Data'
            ]
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Sopir::class);


        // mengubah nama validasi
        $messages = [
            'kd_sopir.required' => 'Kode Sopir tidak boleh kosong',
            'nm_sopir.required' => 'Nama Sopir tidak boleh kosong',
            'nm_sopir.min' => 'Nama Sopir minimal 3 karakter',
            'nm_sopir.max' => 'Nama Sopir maksimal 50 karakter',
            'no_ktp.required' => 'Nomor KTP tidak boleh kosong',
            'no_ktp.numeric' => 'Nomor KTP harus berupa angka',
            'no_ktp.min' => 'Nomor KTP minimal 16 karakter',
            'no_ktp.max' => 'Nomor KTP maksimal 16 karakter',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'foto.required' => 'Foto tidak boleh kosong',
            'foto.image' => 'File yang anda pilih bukan foto atau gambar',
            'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
            'foto.dimensions' => 'Foto harus memiliki ratio 1:1 atau berbentuk persegi',
        ];

        $request->validate([
            'kd_sopir' => 'required',
            'nm_sopir' => 'required|min:3|max:50',
            'no_ktp' => 'required|min:16|max:16|unique:sopir,no_ktp',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|min:3',
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

        Sopir::create($input);

        Alert::success('Data Sopir', 'Berhasil Ditambahkan!');
        return redirect('sopir');
    }

    public function show(Sopir $sopir)
    {
        //
    }

    public function edit(Sopir $sopir)
    {
        $this->authorize('update', $sopir);

        return view(
            'pages.sopir.edit',
            compact('sopir'),
            [
                'tittle' => 'Edit Data',
                'judul' => 'Edit Data Sopir',
                'menu' => 'Data Sopir',
                'submenu' => 'Edit Data'
            ]
        );
    }

    public function update(Request $request, Sopir $sopir)
    {
        $this->authorize('update', $sopir);

        $sopir = Sopir::find($sopir->kd_sopir);

        // cek apakah user mengganti foto atau tidak
        if ($request->has('foto')) {

            // hapus foto lama
            $sopir = Sopir::find($sopir->kd_sopir);
            File::delete('images/' . $sopir->foto);
            // mengubah nama validasi
            $messages = [
                'kd_sopir.required' => 'Kode Sopir tidak boleh kosong',
                'nm_sopir.required' => 'Nama Sopir tidak boleh kosong',
                'nm_sopir.min' => 'Nama Sopir minimal 3 karakter',
                'nm_sopir.max' => 'Nama Sopir maksimal 50 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'alamat.min' => 'Alamat minimal 3 karakter',
                'no_ktp.required' => 'Nomor KTP tidak boleh kosong',
                'no_ktp.min' => 'Nomor KTP minimal 16 karakter',
                'no_ktp.max' => 'Nomor KTP maksimal 16 karakter',
                'no_ktp.unique' => 'Nomor KTP sudah terdaftar',
                'no_ktp.numeric' => 'Nomor KTP harus berupa angka',
                'foto.required' => 'Foto tidak boleh kosong',
                'foto.images' => 'File yang anda pilih bukan foto atau gambar',
                'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
                'foto.dimensions' => 'Foto harus memiliki ratio 1:1 atau berbentuk persegi',
            ];
            $rules = [
                'kd_sopir' => 'required',
                'nm_sopir' => 'required|min:3|max:50',
                'jenis_kelamin' => 'required',
                'alamat' => 'required|min:3',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|dimensions:ratio=1/1',
            ];

            if ($request->no_ktp != $sopir->no_ktp) {
                $rules['no_ktp'] = 'required|min:16|max:16|unique:sopir,no_ktp|numeric';
            };

            $input = $request->validate($rules, $messages);

            if ($image = $request->file('foto')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension() . ".webp";
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(150, 150);
                $image_resize->save(public_path($destinationPath . $profileImage));
                $input['foto'] = "$profileImage";
            }

            $sopir->update($input);

            Alert::success('Data Sopir', 'Berhasil diubah!');
            return redirect('sopir');
        } else {
            // mengubah nama validasi
            $messages = [
                'kd_sopir.required' => 'Kode Sopir tidak boleh kosong',
                'nm_sopir.required' => 'Nama Sopir tidak boleh kosong',
                'nm_sopir.min' => 'Nama Sopir minimal 3 karakter',
                'nm_sopir.max' => 'Nama Sopir maksimal 50 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'alamat.min' => 'Alamat minimal 3 karakter',
                'no_ktp.required' => 'Nomor KTP tidak boleh kosong',
                'no_ktp.min' => 'Nomor KTP minimal 16 karakter',
                'no_ktp.max' => 'Nomor KTP maksimal 16 karakter',
                'no_ktp.unique' => 'Nomor KTP sudah terdaftar',
                'no_ktp.numeric' => 'Nomor KTP harus berupa angka',
            ];

            $rules = [
                'kd_sopir' => 'required',
                'nm_sopir' => 'required|min:3|max:50',
                'jenis_kelamin' => 'required',
                'alamat' => 'required|min:3',
            ];

            $sopir = Sopir::find($sopir->kd_sopir);

            if ($request->no_ktp != $sopir->no_ktp) {
                $rules['no_ktp'] = 'required|min:16|max:16|unique:sopir,no_ktp|numeric';
            };

            $input = $request->validate($rules, $messages);

            $sopir->update($input);
            Alert::success('Data Sopir', 'Berhasil diubah!');
            return redirect('sopir');
        }
    }

    public function destroy(Sopir $sopir)
    {
        $this->authorize('delete', $sopir);

        // menghapus foto berdasarkan id
        File::delete('images/' . $sopir->foto);
        $sopir->delete();
        Alert::success('Data Sopir', 'Berhasil dihapus!');
        return redirect('sopir');
    }
}

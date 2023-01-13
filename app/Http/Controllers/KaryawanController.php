<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{

    public function index()
    {
        // join tabel dengan tabel jabatan
        $karyawan = Karyawan::join('jabatan', 'karyawan.kd_jabatan', '=', 'jabatan.id_jabatan')
            ->select('karyawan.*', 'jabatan.nm_jabatan')
            ->get();

        // mengirim tittle dan judul ke view
        return view(
            'karyawan.index',
            [
                'karyawan' => $karyawan,
                'tittle' => 'Data Karyawan',
                'judul' => 'Data Karyawan',
                'menu' => 'Data Karyawan',
                'submenu' => 'Data Karyawan'
            ]
        );
    }

    public function create()
    {

        // mengirim tittle dan judul ke view
        return view(
            'karyawan.create',
            [
                'jabatan' => Jabatan::all(),
                'tittle' => 'Tambah Data',
                'judul' => 'Tambah Data Karyawan',
                'menu' => 'Data Karyawan',
                'submenu' => 'Tambah Data'
            ]
        );
    }


    public function store(Request $request)
    {
        // mengubah nama validasi
        $messages = [
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.min' => 'NIP minimal 11 karakter',
            'nip.max' => 'NIP maksimal 11 karakter',
            'nip.unique' => 'NIP sudah terdaftar',
            'namaDepan.required' => 'Nama Depan tidak boleh kosong',
            'kd_jabatan.required' => 'Kode jabatan tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
            'no_telp.required' => 'Nomor Telepon tidak boleh kosong',
            'no_telp.min' => 'Nomor Telepon minimal 11 karakter',
            'no_telp.max' => 'Nomor Telepon maksimal 12 karakter',
            'no_telp.numeric' => 'Nomor Telepon harus berupa angka',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'select_kota.required' => 'Kota / Kabupaten',
            'kota.required' => 'Kota tidak boleh kosong',
            'kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'alamat_lengkap.required' => 'Alamat tidak boleh kosong',
            'role.required' => 'Harap tentukan dia login sebagai apa!',
            'foto.required' => 'Foto tidak boleh kosong',
            'foto.images' => 'File yang anda pilih bukan foto atau gambar',
            'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
        ];

        $this->validate($request, [
            'nip' => 'required|min:11|max:11|unique:karyawan,nip',
            'namaDepan' => 'required',
            'kd_jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'no_telp' => 'required|min:11|min:12|numeric',
            'provinsi' => 'required',
            'select_kota' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'alamat_lengkap' => 'required',
            'role' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
        ], $messages);

        // cek apakah nama belakang diisi
        if ($request->namaBelakang) {
            $nm_karyawan = [
                $request->namaDepan,
                $request->namaBelakang
            ];
            $nm_karyawan = implode(' ', $nm_karyawan);
        } else {
            $nm_karyawan = $request->namaDepan;
        }

        // menggabungkan tempat dan tanggal lahir
        $ttl = [
            $request->tempat_lahir,
            $request->tgl_lahir
            // date('d F Y', strtotime($request->tgl_lahir))
        ];
        $ttl = implode(', ', $ttl);

        // menggabungkan kecamatan, kota, provinsi, dan nama jalan menjadi alamat lengkap
        $alamat = [
            $request->alamat_lengkap,
            'Kec. ' . $request->kecamatan,
            $request->select_kota . ' ' . $request->kota,
            'Prov. ' . $request->provinsi
        ];
        $alamat = strtoupper(implode(', ', $alamat)); // mengubah string menjadi huruf besar semua

        $no_telp = '+62' . $request->no_telp;

        // upload foto
        if ($image = $request->file('foto')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $foto = "$profileImage";
        }

        Karyawan::create([
            'nip' => $request->nip,
            'nm_karyawan' => $nm_karyawan,
            'kd_jabatan' => $request->kd_jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $ttl,
            'no_telp' => $no_telp,
            'alamat' => $alamat,
            'role' => $request->role,
            'foto' => $foto
        ]);

        Alert::success('Data Karyawan', 'Berhasil Ditambahkan!');
        return redirect('karyawan');
    }


    public function show($id)
    {
        //
    }


    public function edit(Karyawan $karyawan)
    {

        // memisahkan nama depan dan nama belakang
        $dataNama = explode(' ', $karyawan->nm_karyawan);
        $namaDepan = $dataNama[0];
        $namaBelakang = $dataNama[1];

        // memisahkan tempat dan tanggal lahir
        $dataTtl = explode(', ', $karyawan->ttl);
        $tempatLahir = $dataTtl[0];
        $tanggalLahir = $dataTtl[1];

        // mwngubah huruf kecil semua
        $karyawan->alamat = strtolower($karyawan->alamat);

        // mwngubah awal setiap kalimat jadi huruf kapital
        $karyawan->alamat = ucwords($karyawan->alamat);

        // memisahkan bagian bagian dari alamat
        $dataAlamat = explode(', ', $karyawan->alamat);
        $namaJalan = $dataAlamat[0];

        // memisahkan kecamatan
        $dataKecamatan = explode('. ', $dataAlamat[1]);
        $kecamatan = $dataKecamatan[1];

        // memisahkan kota
        $dataKota = explode(' ', $dataAlamat[2]);
        $selectKota = $dataKota[0];
        $kota = $dataKota[1];

        // memisahkan provinsi
        $dataProvinsi = explode('. ', $dataAlamat[3]);
        $provinsi = $dataProvinsi[1];

        // memisahkan nomor telepon
        $dataNoTelp = explode('+62', $karyawan->no_telp);
        $noTelp = $dataNoTelp[1];

        // dd($namaDepan, $namaBelakang, $tempatLahir, $tanggalLahir, $namaJalan, $kecamatan, $selectKabupaten, $kabupaten, $provinsi);

        // mengirim tittle dan judul ke view
        return view(
            'karyawan.edit',
            [
                'dataKaryawan' => [
                    'namaDepan' => $namaDepan,
                    'namaBelakang' => $namaBelakang,
                    'tempat_lahir' => $tempatLahir,
                    'tgl_lahir' => $tanggalLahir,
                    'no_telp' => $noTelp,
                    'alamat_lengkap' => $namaJalan,
                    'kecamatan' => $kecamatan,
                    'select_kota' => $selectKota,
                    'kota' => $kota,
                    'provinsi' => $provinsi
                ],
                'karyawan' => $karyawan,
                'jabatan' => Jabatan::all(),
                'tittle' => 'Edit Data',
                'judul' => 'Edit Data Karyawan',
                'menu' => 'Data Karyawan',
                'submenu' => 'Edit Data'
            ]
        );
    }


    public function update(Request $request, Karyawan $karyawan)
    {
        // cek apakah user mengganti foto atau tidak
        if ($request->has('foto')) {

            // hapus foto lama
            $karyawan = Karyawan::find($karyawan->id_karyawan);
            File::delete('images/' . $karyawan->foto);

            // mengubah nama validasi
            $messages = [
                'namaDepan.required' => 'Nama Depan tidak boleh kosong',
                'kd_jabatan.required' => 'Kode jabatan tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'no_telp.required' => 'Nomor Telepon tidak boleh kosong',
                'no_telp.min' => 'Nomor Telepon minimal 11 karakter',
                'no_telp.max' => 'Nomor Telepon maksimal 12 karakter',
                'no_telp.numeric' => 'Nomor Telepon harus berupa angka',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'select_kota.required' => 'Kota / Kabupaten',
                'kota.required' => 'Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'alamat_lengkap.required' => 'Alamat tidak boleh kosong',
                'role.required' => 'Harap tentukan dia login sebagai apa!',
                'foto.required' => 'Foto tidak boleh kosong',
                'foto.images' => 'File yang anda pilih bukan foto atau gambar',
                'foto.mimes' => 'File atau Foto harus berupa jpeg,png,jpg,gif,svg,webp',
                'nip.required' => 'NIP tidak boleh kosong',
                'nip.min' => 'NIP minimal 11 karakter',
                'nip.max' => 'NIP maksimal 11 karakter',
                'nip.unique' => 'NIP sudah terdaftar',
            ];

            $rules = [
                'namaDepan' => 'required',
                'kd_jabatan' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'no_telp' => 'required|min:11|min:12|numeric',
                'provinsi' => 'required',
                'select_kota' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'alamat_lengkap' => 'required',
                'role' => 'required',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            if ($request->nip != $karyawan->nip) {
                $rules['nip'] = 'required|min:11|max:11|unique:karyawan,nip';
            };

            $input = $request->validate($rules, $messages);

            // cek apakah nama belakang diisi
            if ($request->namaBelakang) {
                $nm_karyawan = [
                    $input['namaDepan'],
                    $request->namaBelakang
                ];
                $input['nm_karyawan'] = implode(' ', $nm_karyawan);
            } else {
                $input['nm_karyawan'] = $input['namaDepan'];
            }

            // menggabungkan tempat dan tanggal lahir
            $ttl = [
                $input['tempat_lahir'],
                $input['tgl_lahir']
                // date('d F Y', strtotime($input['tgl_lahir))
            ];
            $input['ttl'] = implode(', ', $ttl);

            // menggabungkan kecamatan, kota, provinsi, dan nama jalan menjadi alamat lengkap
            $alamat = [
                $input['alamat_lengkap'],
                'Kec. ' . $input['kecamatan'],
                $input['select_kota'] . ' ' . $input['kota'],
                'Prov. ' . $input['provinsi']
            ];
            $input['alamat'] = strtoupper(implode(', ', $alamat)); // mengubah string menjadi huruf besar semua

            $input['no_telp'] = '+62' . $input['no_telp'];

            if ($image = $request->file('foto')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['foto'] = "$profileImage";
            }

            $karyawan->update($input);

            Alert::success('Data Karyawan', 'Berhasil diubah!');
            return redirect()->route('karyawan.index');
        } else {
            // mengubah nama validasi
            $messages = [
                'namaDepan.required' => 'Nama Depan tidak boleh kosong',
                'kd_jabatan.required' => 'Kode jabatan tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'no_telp.required' => 'Nomor Telepon tidak boleh kosong',
                'no_telp.min' => 'Nomor Telepon minimal 11 karakter',
                'no_telp.max' => 'Nomor Telepon maksimal 12 karakter',
                'no_telp.numeric' => 'Nomor Telepon harus berupa angka',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'select_kota.required' => 'Kota / Kabupaten',
                'kota.required' => 'Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'alamat_lengkap.required' => 'Alamat tidak boleh kosong',
                'nip.required' => 'NIP tidak boleh kosong',
                'nip.min' => 'NIP minimal 11 karakter',
                'nip.max' => 'NIP maksimal 11 karakter',
                'nip.unique' => 'NIP sudah terdaftar',
                'role.required' => 'Harap tentukan dia login sebagai apa!',
            ];

            $rules = [
                'namaDepan' => 'required',
                'kd_jabatan' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'no_telp' => 'required|min:11|min:12|numeric',
                'provinsi' => 'required',
                'select_kota' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'role' => 'required',
                'alamat_lengkap' => 'required'
            ];

            $karyawan = Karyawan::find($karyawan->id_karyawan);

            if ($request->nip != $karyawan->nip) {
                $rules['nip'] = 'required|min:11|max:11|unique:karyawan,nip';
            };

            $input = $request->validate($rules, $messages);

            // cek apakah nama belakang diisi
            if ($request->namaBelakang) {
                $nm_karyawan = [
                    $input['namaDepan'],
                    $request->namaBelakang
                ];
                $input['nm_karyawan'] = implode(' ', $nm_karyawan);
            } else {
                $input['nm_karyawan'] = $input['namaDepan'];
            }

            // menggabungkan tempat dan tanggal lahir
            $ttl = [
                $input['tempat_lahir'],
                $input['tgl_lahir']
                // date('d F Y', strtotime($input['tgl_lahir))
            ];
            $input['ttl'] = implode(', ', $ttl);

            // menggabungkan kecamatan, kota, provinsi, dan nama jalan menjadi alamat lengkap
            $alamat = [
                $input['alamat_lengkap'],
                'Kec. ' . $input['kecamatan'],
                $input['select_kota'] . ' ' . $input['kota'],
                'Prov. ' . $input['provinsi']
            ];
            $input['alamat'] = strtoupper(implode(', ', $alamat)); // mengubah string menjadi huruf besar semua

            $input['no_telp'] = '+62' . $input['no_telp'];

            $karyawan->update($input);
            Alert::success('Data Karyawan', 'Berhasil diubah!');
            return redirect()->route('karyawan.index');
        }
    }

    public function destroy(Karyawan $karyawan)
    {
        File::delete('images/' . $karyawan->foto);
        $karyawan->delete();
        Alert::success('Data Karyawan', 'Berhasil dihapus!');
        return redirect('karyawan');
    }
}

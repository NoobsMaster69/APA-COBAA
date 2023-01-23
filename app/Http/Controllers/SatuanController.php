<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Satuan::class);

        $search = $request->search;

        $satuan = Satuan::where('nm_satuan', 'LIKE', '%' . $search . '%')
            ->oldest()->paginate(10)->withQueryString();

        foreach ($satuan as $sat);

        // mengirim tittle dan judul ke view
        return view(
            'pages.satuan.index',
            [
                'sat' => $sat,
                'satuan' => $satuan,
                'tittle' => 'Data Satuan',
                'judul' => 'Data Satuan',
                'menu' => 'Data Satuan',
                'submenu' => 'Data Satuan'
            ]
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Satuan::class);

        // mengubah error ke bahasa indonesia
        $messages = [
            'required' => ':attribute tidak boleh kosong',
        ];

        $errors = [
            'nm_satuan' => 'Nama Satuan',
        ];

        // validasi data
        $request->validate([
            'nm_satuan' => 'required',
        ], $messages, $errors);



        Satuan::create($request->all());

        Alert::success('Data Satuan', 'Berhasil Ditambahkan!');
        return redirect('satuan');
    }

    public function update(Request $request, Satuan $satuan)
    {
        $this->authorize('update', $satuan);

        $request->validate([
            'nm_satuan' => 'required'
        ]);

        $satuan->update($request->all());
        Alert::success('Data Satuan', 'Berhasil diubah!');
        return redirect('satuan');
    }

    public function destroy(Satuan $satuan)
    {
        $this->authorize('delete', $satuan);

        $satuan->delete();
        Alert::success('Data Satuan', 'Berhasil dihapus!');
        return redirect('satuan');
    }
}

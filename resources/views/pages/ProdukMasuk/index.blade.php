@extends('../layout/' . $layout)

@section('subhead')
<title>Data Pembuatan Produk - Bread Smile</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10">Data Pembuatan Produk</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{route ('produkMasuk.create') }}">
            <button class="btn btn-primary shadow-md mr-2">Tambah Data</button>
        </a>
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center">
                    <i class="w-4 h-4" data-feather="plus"></i>
                </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="" class="dropdown-item">
                            <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                        </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item">
                            <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel
                        </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item">
                            <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-slate-500">
                <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report mt-2 table-fixed">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">KODE PRODUK</th>
                    <th class="text-center whitespace-nowrap">RESEP</th>
                    <th class="whitespace-nowrap">NAMA PRODUK</th>
                    <th class="text-center whitespace-nowrap">PENCATAT</th>
                    <th class="text-center whitespace-nowrap">JUMLAH </th>
                    <th class="text-center whitespace-nowrap">TANGGAL PRODUKSI</th>
                    <th class="text-center whitespace-nowrap">TANGGAL EXPIRED</th>
                    <th class="text-center whitespace-nowrap">HARGA JUAL</th>
                    <th class="text-center whitespace-nowrap">MODAL</th>
                    <th class="text-center whitespace-nowrap">TOTAL</th>
                    <th class="text-center whitespace-nowrap">KETERANGAN</th>
                    <th class="text-center whitespace-nowrap">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkMasuk as $masuk)
                <tr class="intro-x">
                    <td class="whitespace-nowrap">{{ $masuk->kd_produk }}</td>
                    <td class="text-center whitespace-nowrap">{{ $masuk->nm_produk }}</td>
                    <td class="whitespace-nowrap">{{ $masuk->bahan }}</td>
                    <td class="text-center whitespace-nowrap">{{ $masuk->name }}</td>
                    <td class="text-center whitespace-nowrap">{{ $masuk->jumlah }} {{ $masuk->nm_satuan }}</td>
                    <td class="text-center whitespace-nowrap">{{ date('d F Y',strtotime($masuk->tgl_produksi)) }}</td>
                    <td class="text-center whitespace-nowrap">{{ date('d F Y',strtotime($masuk->tgl_expired)) }}</td>
                    <td class="text-center whitespace-nowrap">Rp. {{ number_format($masuk->modal, 0, ',', '.') }}</td>
                    <td class="text-center whitespace-nowrap">Rp. {{ number_format($masuk->total, 0, ',', '.') }}</td>
                    <td class="text-center whitespace-nowrap">{{ $masuk->ket }}</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a href="{{ route('produkMasuk.edit', $masuk->id_produkMasuk) }}" class="flex items-center mr-3" href="javascript:;">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <!-- trigger modal -->
                            <button class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#hapus{{ $masuk->kd_produk }}">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                            </button>
                            <!-- BEGIN: Delete Confirmation Modal -->
                            <div id="hapus{{ $masuk->kd_produk }}" class="modal pt-16" tabindex="-1" aria-hidden="true" varia-labelledby="exampleModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <form action="{{ route('produkMasuk.destroy', $masuk->id_produkMasuk) }}"  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="p-5 text-center">
                                                    <i data-feather="trash-2" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                    <div id="exampleModalLabel" class="text-3xl mt-5">Apakah yakin akan menghapus bahan {{ $masuk->nm_produk }}?</div>
                                                    <div class="text-slate-500 mt-2">Data yang dihapus tidak dapat dikembalikan!</div>
                                                </div>
                                                <div class="px-5 pb-8 text-center">
                                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Kembali</button>
                                                    <button type="submit" class="btn btn-danger w-24">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Delete Confirmation Modal -->
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="w-4 h-4" data-feather="chevrons-left"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="w-4 h-4" data-feather="chevron-left"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="w-4 h-4" data-feather="chevron-right"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="w-4 h-4" data-feather="chevrons-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <select class="w-20 form-select box mt-3 sm:mt-0">
            <option>10</option>
            <option>25</option>
            <option>35</option>
            <option>50</option>
        </select>
    </div>
    <!-- END: Pagination -->
</div>

<!-- BEGIN: Notification Content -->
<div id="success-notification-content" class="toastify-content hidden flex">
    <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Data Berhasil Di simpan Saved!</div>
        <div class="text-slate-500 mt-1">The message will be sent in 5 minutes.</div>
    </div>
</div>
<!-- END: Notification Content -->
@endsection

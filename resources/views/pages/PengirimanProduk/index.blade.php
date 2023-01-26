@extends('../layout/' . $layout)

@section('subhead')
<title>{{ $tittle }} - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y mt-10">
    <h2 class="text-lg font-medium">{{ $judul }}</h2>
    <ol class="breadcrumb breadcrumb-dark mt-2 mr-auto ml-1">
        <li class="breadcrumb-item"><a href="/pengirimanProduk" class="text-slate-600">{{ $menu }}</a></li>
        <li class="breadcrumb-item active"><a class="text-slate-700 font-medium">{{ $submenu }}</a></li>
    </ol>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    @can('create', App\Models\PengirimanProduk::class)
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{ route('pengirimanProduk.create') }}">
            <button class="btn btn-primary shadow-md mr-2">Tambah Pengiriman</button>
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
        <div class="hidden md:block mx-auto text-slate-500"></div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-slate-500">
                <form action="">
                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search..." autocomplete="off" name="search" value="{{ request('search') }}">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                </form>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap text-center">NO.</th>
                    <th class="whitespace-nowrap text-center">KODE PRODUK</th>
                    <th class="whitespace-nowrap text-center">NAMA PRODUK</th>
                    <th class="whitespace-nowrap text-center">JUMLAH</th>
                    <th class="whitespace-nowrap text-center">TANGGAL PENGIRIMAN</th>
                    <th class="whitespace-nowrap text-center">SOPIR (PLAT MOBIL)</th>
                    <th class="whitespace-nowrap text-center">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengirimanProduk as $produk)
                <tr class="intro-x">
                    <td class="text-center">{{ $loop->iteration + ($pengirimanProduk->currentPage() - 1) * $pengirimanProduk->perPage() }}</td>
                    <td class="text-center">{{ $produk->kd_produk }}</td>
                    <td class="text-center">{{ $produk->nm_produk }}</td>
                    <td class="text-center">{{ $produk->jumlah }} {{ $produk->nm_satuan }}</td>
                    <td class="text-center">{{ date('d F Y',strtotime($produk->tgl_pengiriman)) }}</td>
                    <td class="text-center">{{ $produk->nm_sopir }} ({{ $produk->plat_nomor }})</td>
                    <td class="text-center">
                        @if ($produk->status == 0)
                        <span class="text-warning">Menunggu Konfirmasi Sopir</span>
                        @elseif ($produk->status == 1)
                        <span class="text-primary">Sedang Dikirim</span>
                        @elseif ($produk->status == 2)
                        <span class="text-success">Selesai</span>
                        @endif
                    </td>
                    <!-- <td class="table-report__action">
                        <div class="flex justify-center items-center">

                            <a class="flex items-center mr-2 tooltip text-success" data-theme="light" title="Edit" href="{{ route('pengirimanProduk.edit', $produk->id_pengirimanProduk) }}">
                                <i data-feather="check-square" class="w-4 h-4"></i>
                            </a> -->

                    <!-- trigger modal -->
                    <!-- <button class="flex items-center tooltip text-danger" data-theme="light" title="Hapus" data-tw-toggle="modal" data-tw-target="#hapus{{ $produk->id_pengirimanProduk }}">
                                <i data-feather="trash-2" class="w-4 h-4"></i>
                            </button> -->
                    <!-- BEGIN: Delete Confirmation Modal -->
                    <!-- <div id="hapus{{ $produk->id_pengirimanProduk }}" class="modal pt-16" tabindex="-1" aria-hidden="true" varia-labelledby="exampleModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <form action="{{ route('pengirimanProduk.destroy', $produk->id_pengirimanProduk) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="p-5 text-center">
                                                    <i data-feather="trash-2" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                    <div id="exampleModalLabel" class="text-2xl mt-5">Apakah yakin ingin menghapus produk <br> {{ $produk->nm_produk }} ?</div>
                                                    <div class="mt-3">
                                                        <span class="text-danger">*data yang dihapus tidak dapat dikembalikan!</span>
                                                    </div>
                                                </div>
                                                <div class="px-5 pb-8 text-center">
                                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Kembali</button>
                                                    <button type="submit" class="btn btn-danger w-24">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                    <!-- END: Delete Confirmation Modal -->
                    <!-- </div>
                        </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <div class="w-full sm:w-auto sm:mr-auto">
            {{ $pengirimanProduk->withQueryString()->links() }}
        </div>
    </div>
    <!-- END: Pagination -->
    @endcan

    @can('sopir')
    <!-- menampilkan dan mengirimkan konfirmasi  -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <!-- <th class="whitespace-nowrap text-center">NO.</th> -->
                    <th class="whitespace-nowrap text-center">KONFIRMASI</th>
                    <th class="whitespace-nowrap text-center">STATUS</th>
                    <th class="whitespace-nowrap text-center">DETAIL</th>
                    <!-- <th class="whitespace-nowrap text-center">KODE PRODUK</th>
                    <th class="whitespace-nowrap text-center">NAMA PRODUK</th>
                    <th class="whitespace-nowrap text-center">JUMLAH</th>
                    <th class="whitespace-nowrap text-center">TANGGAL PENGIRIMAN</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($pengirimanProduk as $produk)
                @if ($produk->kd_sopir == Auth::user()->id_karyawan)
                <tr class="intro-x">
                    <!-- <td class="text-center">{{ $loop->iteration + ($pengirimanProduk->currentPage() - 1) * $pengirimanProduk->perPage() }}</td> -->
                    <td class="text-center">
                        @if ($produk->status == 0)
                        <form action="{{ route('pengirimanProduk.update', $produk->id_pengirimanProduk) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success text-white">Kirim</button>
                        </form>
                        @elseif ($produk->status == 1)
                        <form action="{{ route('pengirimanProduk.update', $produk->id_pengirimanProduk) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-success text-white">Sampai</button>
                        </form>
                        @elseif ($produk->status == 2)
                        <span class="mx-auto" data-feather="check"></span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($produk->status == 0)
                        <span class="text-warning">Menunggu Konfirmasi Sopir</span>
                        @elseif ($produk->status == 1)
                        <span class="text-primary">Sedang Dikirim</span>
                        @elseif ($produk->status == 2)
                        <span class="text-success">Selesai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="flex items-center tooltip text-primary mx-auto" data-theme="light" title="Detail" data-tw-toggle="modal" data-tw-target="#detail-{{ $produk->id_pengirimanProduk }}">
                            <i data-feather="alert-circle" class="mx-auto"></i>
                        </button>
                    </td>
                    <!-- <td class="text-center">{{ $produk->kd_produk }}</td>
                    <td class="text-center">{{ $produk->nm_produk }}</td>
                    <td class="text-center">{{ $produk->jumlah }} {{ $produk->nm_satuan }}</td>
                    <td class="text-center">{{ date('d F Y',strtotime($produk->tgl_pengiriman)) }}</td> -->
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->

    @endcan

    <!-- tampilan untuk sopir mengupdate status -->
</div>
@can('sopir')
@foreach ($pengirimanProduk as $produk)
@include('pages.PengirimanProduk.detail')
@endforeach
@endcan

@endsection
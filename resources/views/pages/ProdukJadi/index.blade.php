@extends('../layout/' . $layout)

@section('subhead')
    <title>Product Grid - Midone - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">Produk Jadi </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{route ('produkJadi.create') }}">
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
        <!-- BEGIN: Users Layout -->
        @foreach ($produkJadi as $produk)
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                <div class="box">
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                            <img  class="rounded-md" src="{{ asset('images/'.$produk->foto) }}">
                                <span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10"></span>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <a href="{{ route('produkJadi.edit',$produk->kd_produk) }}" class="block font-medium text-base">{{ $produk->nm_produk }}</a>
                                <span class="text-white/90 text-xs mt-3">Roti</span>
                            </div>
                        </div>
                        <div class="text-slate-600 dark:text-slate-500 mt-5">
                            <div class="flex items-center">
                                <i data-feather="link" class="w-4 h-4 mr-2"></i> Harga: Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}
                            </div>
                            <div class="flex items-center mt-2">
                                <i data-feather="box" class="w-4 h-4 mr-2"></i>  Stock: {{ $produk['stok']}}
                            </div>
                            <div class="flex items-center mt-2">
                                <i data-feather="clipboard" class="w-4 h-4 mr-2"></i> Keterangan: {{ $produk['ket'] }}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                        <a class="flex items-center text-primary mr-auto" href="javascript:;">
                            <i data-feather="eye" class="w-4 h-4 mr-1"></i> Preview
                        </a>
                        <a href="{{ route('produkJadi.edit',$produk->kd_produk) }}" class="flex items-center mr-3" href="javascript:;" >
                            <i data-feather="check-square" class="w-4 h-4 mr-1" ></i> Edit
                        </a>
                        <button class="flex items-center text-danger"  data-tw-toggle="modal" data-tw-target="#hapus{{ $produk->kd_produk }}">
                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <div id="hapus{{ $produk->kd_produk }}" class="modal pt-16" tabindex="-1" aria-hidden="true" varia-labelledby="exampleModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <form action="{{ route('produkJadi.destroy', $produk->kd_produk) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="p-5 text-center">
                                    <i data-feather="trash-2" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                    <div id="exampleModalLabel" class="text-3xl mt-5">Apakah yakin akan menghapus bahan {{ $produk->nm_produk }}?</div>
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

        @endforeach
        <!-- END: Users Layout -->
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
@endsection

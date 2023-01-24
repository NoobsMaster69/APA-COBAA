@extends('../layout/' . $layout)

@section('subhead')
<title>{{ $tittle }} - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y mt-10">
    <h2 class="text-lg font-medium">{{ $judul }}</h2>
    <ol class="breadcrumb breadcrumb-dark mt-2 mr-auto ml-1">
        <li class="breadcrumb-item"><a href="/satuan" class="text-slate-600">{{ $menu }}</a></li>
        <li class="breadcrumb-item active"><a class="text-slate-700 font-medium">{{ $submenu }}</a></li>
    </ol>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        @can('create', App\Models\Satuan::class)
        <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#tambahSatuan">Tambah Satuan</button>
        @endcan
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
        <table class="table table-report -mt-2 table-fixed">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">NO.</th>
                    <th class="whitespace-nowrap ">NAMA SATUAN</th>
                    @can('update', $sat)
                    <th class="whitespace-nowrap text-center">AKSI</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($satuan as $sat)
                <tr class="intro-x">
                    <td class="">{{ $satuan->firstItem() + $loop->index }}</td>
                    <td class="">{{ $sat->nm_satuan }}</td>
                    @can('update', $sat)
                    <td class="table-report__action">
                        <div class="flex justify-center items-center">
                        
                            <button class="flex items-center mr-3" data-tw-toggle="modal" data-tw-target="#editSatuan-{{ $sat->id_satuan }}">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </button>

                            <!-- trigger modal -->
                            <button class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#hapus{{ $sat->id_satuan }}">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                            </button>
                            <!-- BEGIN: Delete Confirmation Modal -->
                            <div id="hapus{{ $sat->id_satuan }}" class="modal pt-16" tabindex="-1" aria-hidden="true" varia-labelledby="exampleModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <form action="{{ route('satuan.destroy', $sat->id_satuan) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="p-5 text-center">
                                                    <i data-feather="trash-2" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                    <div id="exampleModalLabel" class="text-2xl mt-5">Apakah yakin ingin menghapus <br> {{ $sat->nm_satuan }} ?</div>
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
                            </div>
                            <!-- END: Delete Confirmation Modal -->
                        </div>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <div class="w-full sm:w-auto sm:mr-auto">
            {{ $satuan->withQueryString()->links() }}
        </div>
    </div>
    <!-- END: Pagination -->

</div>

{{-- modal tambah data --}}
@include('pages.satuan.create')

{{-- modal edit data --}}
@foreach ($satuan as $st)
@include('pages.satuan.edit')
@endforeach

@endsection
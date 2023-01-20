@extends('../layout/' . $layout)

@section('subhead')
<title>Data Karyawan - Bread Smile</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10">Data Karyawan</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{ route('karyawan.create') }}">
            <button class="btn btn-primary shadow-md mr-2">Tambah Karyawan</button>
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
                    <th class="whitespace-nowrap">NO.</th>
                    <th class="text-center whitespace-nowrap">FOTO</th>
                    <th class="text-center whitespace-nowrap">NIP</th>
                    <th class="text-center whitespace-nowrap">NAMA</th>
                    <th class="text-center whitespace-nowrap">JABATAN</th>
                    <th class="text-center whitespace-nowrap">TTL</th>
                    <th class="text-center whitespace-nowrap">NO TELEPON</th>
                    {{-- <th class="text-center whitespace-nowrap">ALAMAT</th> --}}
                    <th class="text-center whitespace-nowrap">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $krywn)
                <tr class="intro-x">
                    <!-- agar nomer mengikuti pagination -->
                    <td class="text-center">{{ $loop->iteration + ($karyawan->currentPage() - 1) * $karyawan->perPage() }}</td>
                    <td class="text-center">
                        <img src="{{ asset('images/'.$krywn->foto) }}" class="w-[50px]">
                    </td>
                    <td class="text-center">{{ $krywn->nip }}</td>
                    <td class="text-center">{{ $krywn->nm_karyawan }}</td>
                    <td class="text-center">{{ $krywn->nm_jabatan }}</td>
                    <td class="text-center">{{ $krywn->ttl }}</td>
                    <td class="text-center">{{ $krywn->no_telp }}</td>
                    {{-- <td class="text-center">{{ $krywn->alamat }}</td> --}}
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="{{ route('karyawan.edit', $krywn->id_karyawan) }}">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>

                            <!-- trigger modal -->
                            <button class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#hapus{{ $krywn->id_karyawan }}">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                            </button>
                            <!-- BEGIN: Delete Confirmation Modal -->
                            <div id="hapus{{ $krywn->id_karyawan }}" class="modal pt-16" tabindex="-1" aria-hidden="true" varia-labelledby="exampleModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <form action="{{ route('karyawan.destroy', $krywn->id_karyawan) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="p-5 text-center">
                                                    <i data-feather="trash-2" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                    <div id="exampleModalLabel" class="text-3xl mt-5">Apakah yakin akan menghapus {{ $krywn->nm_karyawan }}?</div>
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
        <div class="w-full sm:w-auto sm:mr-auto">
            {{ $karyawan->withQueryString()->links() }}
        </div>
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
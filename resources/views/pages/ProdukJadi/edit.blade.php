@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Data Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y box lg:mt-5">
    <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">Display Information</h2>
    </div>
    <form action="{{ route('produkJadi.update', $produkJadi->kd_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="p-5">
        <div class="flex flex-col-reverse xl:flex-row flex-col">
            <div class="flex-1 mt-6 xl:mt-0">
                <div class="grid grid-cols-12 gap-x-5">
                    <div class="col-span-12 2xl:col-span-6">
                        <div>
                            <label for="update-profile-form-1" class="form-label">Display Name</label>
                            <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" id="kd_produk" name="kd_produk" value="{{ $produkJadi->kd_produk }}" disabled>
                        </div>
                        <div class="mt-3">
                            <label for="update-profile-form-1" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="stok" name="stok" value="{{ $produkJadi->stok }}" required>
                            @error('stok')
                            <div class="text-danger mt-2 mx-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mt-3">
                        <label for="stok" class="form-label"> Stok </label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input name="stok" id="stok" type="number" class="form-control block w-full @error('stok') border-danger @enderror rounded-md border-gray-300 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Stok" value="{{ $produkJadi->stok }}">
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <select name="kd_satuan" id="satuan" class="form-control h-full rounded-md  @error('kd_satuan') border-danger @enderror border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="{{ $produkJadi->kd_satuan }}" selected hidden>{{ $produkJadi->nm_satuan }}</option>
                                    @foreach ($satuan as $sat)
                                    <option value="{{ $sat->id_satuan }}">{{ $sat->nm_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('stok')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                        @error('kd_satuan')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        </div>
                        @enderror
                        <div class="mt-3">
                            <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="{{ $produkJadi->harga_jual }}" required>
                        @error('harga_jual')
                        <div class="text-danger mt-2 mx-1">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                    </div>
                    <div class="col-span-12">
                        <div class="mt-3">
                            <label for="ket">Keterangan</label>
                            <textarea class="form-control" id="ket" name="ket" required>{{ $produkJadi->ket }}</textarea>
                            @error('ket')
                            <div class="text-danger mt-2 mx-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-primary w-20 mt-3">Save</button>
            </div>
            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                        <img class="rounded-md"  src="{{ asset('images/'.$produkJadi->foto) }}">
                        <div>
                            <i data-feather="x" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="mx-auto cursor-pointer relative mt-5">
                        <button type="button" class="btn btn-primary w-full">Change Photo</button>
                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
    @endsection

    @section('script')
    <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
    @endsection

@extends('../layout/' . $layout)

@section('subhead')
<title>Tambah Data Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Null </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form action="{{ route('produkJadi.store') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="mt-3">
                    <label for="kd_bahan" class="form-label"> Kode Produk </label>
                    <input type="text" class="form-control" id="kd_produk" name="kd_produk" value="{{ $kode_otomatis }}" readonly>
                </div>
                <div class="mt-3">
                    <label for="nm_produk" class="form-label"> Nama Produk </label>
                    <input type="text" class="form-control" name="nm_produk" id="nm_produk" value="{{ old('nm_produk') }}" placeholder="Masukkan Nama Produk">
                    @error('nm_produk')
                    <div class="text-danger mt-2 mx-1">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="mt-3">
                    <label for="stok" class="form-label"> Stok </label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        </div>
                        <input name="stok" id="stok" type="number" class="form-control block w-full @error('stok') border-danger @enderror rounded-md border-gray-300 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Stok" value="{{ old('stok') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select name="kd_satuan" id="satuan" class="form-control h-full rounded-md  @error('kd_satuan') border-danger @enderror border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option disabled hidden selected>-- Pilih Satuan --</option>
                                @foreach ($satuan as $sat)
                                @if (old('kd_satuan') == $sat->id_satuan)
                                <option value="{{ $sat->id_satuan }}" selected>{{ $sat->nm_satuan }}</option>
                                @else
                                <option value="{{$sat->id_satuan }}">{{ $sat->nm_satuan }}</option>
                                @endif
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
                    @enderror
                    <div class="mt-3">
                        <label for="nm_produk" class="form-label"> Harga Jual Produk </label>
                        <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" placeholder="Masukkan Harga Jual">
                        @error('harga_jual')
                        <div class="text-danger mt-2 mx-1">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="input-form mt-3">
                        <label for="ket" class="form-label w-full flex flex-col sm:flex-row">
                            Keterangan
                        </label>
                        <textarea name="ket" id="ket" class="form-control @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan">{{ old('ket') }}</textarea>
                    </div>
                    @error('ket')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="intro-y flex items-center mt-8">

                </div>
                <div class="relative">
                    <div class="intro-y col-span-11 2xl:col-span-9">
            <!-- BEGIN: Uplaod Foto -->
            <div class="intro-y box p-5">
                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                        <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Upload Produk
                    </div>
                    <div class="mt-5">
                        <div class="flex items-center text-slate-500">
                            <span><i data-lucide="lightbulb" class="w-5 h-5 text-warning"></i></span>
                        </div>
                        <div class="form-inline items-start flex-col xl:flex-row mt-10">
                            <div class="form-label w-full xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Foto Produk</div>
                                    </div>
                                    <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                        <div>Format foto yang didukung hanya .jpg .jpeg .png.</div>
                                        <div class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5">
                                        <div class="col-span-5 md:col-span-2 h-28 relative image-fit cursor-pointer zoom-in">
                                            <img class="rounded-md">
                                        </div>
                                </div>
                                <div class="px-4 pb-4 mt-5 flex items-center justify-center cursor-pointer relative">
                                    <i data-feather="image" class="w-4 h-4 mr-2"></i> <span class="text-primary mr-1" for="foto">Upload Foto Produk</span>
                                    <input id="horizontal-form-1"  type="file" class="w-full h-full top-0 left-0 absolute opacity-0" id="foto"  name="foto" value="{{ old('foto') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Uplaod Foto -->
            <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Cancel</button>
                <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Save</button>
            </form>
            </div>

            <!-- END: Form Layout -->
            <!-- <div id="success-notification-content" class="toastify-content hidden flex">
    <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Keren Kamu Bang Sukses !</div>
        <div class="text-slate-500 mt-1">
            Jembut
        </div>
    </div>
</div> -->
            <!-- END: Success Notification Content -->
            <!-- BEGIN: Failed Notification Content -->
            <!-- <div id="failed-notification-content" class="toastify-content hidden flex">
    <i class="text-danger" data-feather="x-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Tambah Data Gagal Anjing !</div>
        <div class="text-slate-500 mt-1">
            Isi dlu semua kontol.
        </div>
    </div>
</div> -->
            <!-- END: Failed Notification Content -->
        </div>


    </div>
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>

@endsection

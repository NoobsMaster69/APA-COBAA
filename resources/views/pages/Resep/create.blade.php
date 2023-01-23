@extends('../layout/' . $layout)

@section('subhead')
<title>Tambah Data Resep - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Tambah Data Resep </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form class="" action="{{ route('resep.store') }}" method="POST">
                @csrf
                <div class="mt-3">
                    <label for="kd_resep" class="form-label font-bold"> Kode Resep </label>
                    <input id="kd_resep" name="kd_resep" type="text" value="{{ $kode_otomatis }}" readonly class="form-control w-full">
                </div>
                <div class="mt-3">
                    <label for="kd_produk" class="form-label font-bold">Nama Produk</label>
                    <div class="mt-1">
                        <select data-placeholder="Silahkan pilih Produk" class="tom-select w-full @error('kd_produk') border-danger @enderror" id="kd_produk" name="kd_produk">
                            <option value="0" hidden disabled selected>-- Silahkan Pilih --</option>
                            @foreach ($produkJadi as $produk)
                            @if (old('kd_produk') == $produk->kd_produk)
                            <option value="{{ $produk->kd_produk }}" selected>[{{ $produk->kd_produk }}] {{ $produk->nm_produk }}</option>
                            @else
                            <option value="{{$produk->kd_produk }}">[{{ $produk->kd_produk }}] {{ $produk->nm_produk }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('kd_produk')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <label for="kd_bahan" class="form-label font-bold">Pilih Bahan-bahan disertai jumlah</label>
                    <div class="overflow-x-auto sm:overflow-x-visible">
                        @foreach ($dataBahan as $bahan)
                        <div class="intro-y">
                            <div class="inbox__item inline-block sm:block text-slate-600 dark:text-slate-500 bg-white dark:bg-darkmode-400/70 border-b border-slate-200/60 dark:border-darkmode-400">
                                <div class="flex px-5 py-3">
                                    <div class="w-40 flex-none flex items-center mr-5">
                                        <input class=" form-check-input flex-none @error('kd_bahan') border-danger @enderror" type="checkbox" value="{{ $bahan->kd_bahan }}" name="kd_bahan[]">
                                        <div class="inbox__item--sender truncate ml-3">{{ $bahan->nm_bahan }}</div>
                                    </div>
                                    <div class="w-80 sm:w-auto truncate">
                                        <span class="inbox__item--highlight">
                                            <input type="number" name="jumlah[]" class="form-control w-full @error('jumlah') border-danger @enderror" placeholder="Berapa {{ $bahan->nm_satuan }}">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('kd_bahan')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="text-right mt-5">
                    <a href="/resep" type="button" class="btn btn-outline-secondary w-24 mr-1">Kembali</a>
                    <button type="submit" class="btn btn-primary w-24">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>

@endsection
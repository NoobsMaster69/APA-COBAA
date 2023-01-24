@extends('../layout/' . $layout)

@section('subhead')
<title>{{ $tittle }} - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y mt-10 mb-6">
    <h2 class="text-lg font-medium mr-auto">{{ $judul }}</h2>
    <ol class="breadcrumb breadcrumb-dark mt-2 mr-auto ml-1">
        <li class="breadcrumb-item"><a href="/dataBahan" class="text-slate-600">{{ $menu }}</a></li>
        <li class="breadcrumb-item active"><a class="text-slate-700 font-medium">{{ $submenu }}</a></li>
    </ol>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form action="{{ route('produkMasuk.store') }}" method="POST">
                @csrf
                <div class="mt-6">
                    <label for="kd_produk" class="form-label"> Kode Produk </label>
                    <div class="relative rounded-md">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        </div>
                        <select name="kd_produk" class="form-select form-control" class="form-control w-full shadow-md  @error('kd_produk')  is-invalid @enderror" required autofocus onchange="changeValue(this.value)" onclick="changeValue(this.value)">
                            <option value="0" hidden disabled selected>Pilih Kode produk</option>

                            @php
                            $jsArray = "var prdName = new Array();\n";
                            @endphp
                            @foreach ($produkJadi as $produk)
                            <option value="{{ $produk->kd_produk }}">{{ $produk->kd_produk }} - {{ $produk->nm_produk }} </option>
                            @php
                            $jsArray .= "prdName['" . $produk['kd_produk'] . "']= {
                            nm_produk : '" . addslashes($produk['nm_produk']) . "',
                            stok : '" . addslashes($produk['stok']) . "',
                            nm_satuan : '" . addslashes($produk['nm_satuan']) . "',
                            nm_satuan2 : '" . addslashes($produk['nm_satuan']) . "',
                            };\n";
                            @endphp
                            @endforeach
                        </select>
                        @error('kd_produk')
                        <div class="col-12 text-danger mt-2 mx-1">
                            {{ $message }}
                        </div>
                        @enderror
                        </div>
                </div>
                {{-- <div class="bg-slate-100 -ml-1 w-full flex justify-center py-2 rounded-lg shadow-lg">
                    <span class="text-slate-800 font-medium uppercase text-center">Kode Bahan - {{ $kode_otomatis }}</span>
                </div> --}}
                <div class="mt-8">
                    <label for="nm_produk" class="form-label"> Nama Produk </label>
                    <input name="nm_produk" id="nm_produk" type="text" class="form-control w-full shadow-md @error('nm_produk') border-danger @enderror" placeholder="Masukkan Nama Bahan" value="{{ old('nm_produk') }}">
                    @error('nm_produk')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="stok" class="form-label"> Stok  </label>
                    <input name="stok" id="stok" type="number" class="form-control w-full shadow-md @error('stok') border-danger @enderror" placeholder="Masukkan Harga Beli" value="{{ old('stok') }}">
                    @error('stok')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-6">
                    <label for="jumlah" class="form-label"> Jumlah  </label>
                    <input name="jumlah" id="jumlah" type="number" class="form-control w-full shadow-md @error('jumlah') border-danger @enderror" placeholder="Masukkan Harga Beli" value="{{ old('jumlah') }}">
                    <input type="text" class="form-control" id="nm_satuan2" readonly>
                    @error('jumlah')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-6">
                    <label for="ket" class="form-label">
                        Keterangan
                    </label>
                    <textarea name="ket" id="ket" class="form-control w-full shadow-md @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan" required>{{ old('ket') }}</textarea>
                    @error('ket')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="relative">
                    <div class="intro-y col-span-11 2xl:col-span-9 mb-3">
                        <div class="flex justify-center flex-col md:flex-row gap-2 mt-8">
                            <a href="/dataBahan" type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Cancel</a>
                            <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Save</button>
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
<script type="text/javascript">
    <?= $jsArray; ?>

    function changeValue(x) {
      document.getElementById('nm_produk').value = prdName[x].nm_produk;
      document.getElementById('stok').value = prdName[x].stok;
      document.getElementById('nm_satuan').value = prdName[x].nm_satuan;
      document.getElementById('nm_satuan2').value = prdName[x].nm_satuan2;
    }
  </script>
@endsection

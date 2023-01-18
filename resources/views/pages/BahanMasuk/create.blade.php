@extends('../layout/' . $layout)

@section('subhead')
<title>Tambah Pembelian Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Pembelian Bahan </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form action="{{ route('bahanMasuk.store') }}" method="POST">
                @csrf
                <div class="mt-3">
                    <label for="kd_bahan" class="form-label font-medium"> Kode Bahan </label>
                    <select name="kd_bahan" id="satuan" id="product-name" type="text" class="form-control w-full" placeholder="Kode Bahan" required autofocus onchange="changeValue(this.value)" onclick="changeValue(this.value)">
                        <option value="0" hidden disabled selected>Pilih Kode Bahan</option>
                        @php
                        $jsArray = "var prdName = new Array();\n";
                        @endphp

                        @foreach ($dataBahan as $bahan)
                        @if (old('kd_bahan') == $bahan->kd_bahan)
                        <option value="{{ $bahan->kd_bahan }}" selected>{{ $bahan->kd_bahan }} - {{ $bahan->nm_bahan }} </option>
                        @else
                        <option value="{{ $bahan->kd_bahan }}">{{ $bahan->kd_bahan }} - {{ $bahan->nm_bahan }} </option>
                        @endif

                        @php
                        $jsArray .= "prdName['" . $bahan['kd_bahan'] . "']= {
                        nm_bahan : '" . addslashes($bahan['nm_bahan']) . "',
                        harga_beli : '" . addslashes($bahan['harga_beli']) . "',
                        harga_beliTampil : '" . addslashes('Rp. ' . number_format($bahan['harga_beli'])) . "',
                        stok : '" . addslashes($bahan['stok']) . "',
                        nm_satuan : '" . addslashes($bahan['nm_satuan']) . "',
                        nm_satuan2 : '" . addslashes($bahan['nm_satuan']) . "',

                        };\n";
                        @endphp

                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="nm_bahan" class="form-label font-medium"> Nama Bahan </label>
                    <input name="nm_bahan" id="nm_bahan" type="text" class="form-control w-full @error('nm_bahan') border-danger @enderror" readonly>
                </div>
                <div class=" mt-3">
                    <label for="harga_beli" class="form-label font-medium"> Harga Bahan </label>
                    <input id="harga_beliTampil" type="text" class="form-control w-full" readonly>
                    <input name="harga_beli" id="harga_beli" type="hidden" class="form-control w-full">
                </div>
                <div class="mt-3">
                    <label for="stok" class="form-label font-medium"> Stok Bahan </label>
                    <input id="stok" type="text" class="form-control w-full" readonly>
                </div>
                <div class=" mt-3">
                    <label for="jumlah" class="form-label font-medium"> Jumlah </label>
                    <input name="jumlah" id="jumlah" type="number" class="form-control w-full @error('jumlah') border-danger @enderror" placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
                </div>
                @error('jumlah')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="mt-3">
                    <label for="tgl_masuk" class="form-label font-medium"> Tanggal Masuk </label>
                    <input type="text" class="datepicker form-control @error('tgl_masuk') border-danger @enderror" data-single-mode="true" value="{{ old('tgl_masuk') }}" name="tgl_masuk" id="tgl_masuk">
                </div>
                @error('tgl_masuk')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="mt-3">
                    <label for="ket" class="form-label font-medium"> Keterangan </label>
                    <textarea name="ket" id="ket" type="text" class="form-control w-full @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan" minlength="3">{{ old('ket') }}</textarea>
                </div>
                @error('ket')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <!-- END: Form Layout -->
                <div class="text-right mt-5">
                    <a href="/bahanmasuk" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



<script type="text/javascript">
    <?= $jsArray; ?>

    function changeValue(x) {
        document.getElementById('nm_bahan').value = prdName[x].nm_bahan;
        document.getElementById('harga_beli').value = prdName[x].harga_beli;
        document.getElementById('harga_beliTampil').value = prdName[x].harga_beliTampil;
        document.getElementById('stok').value = prdName[x].stok;
        document.getElementById('nm_satuan').value = prdName[x].nm_satuan;
        document.getElementById('nm_satuan2').value = prdName[x].nm_satuan2;
    }
</script>
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection
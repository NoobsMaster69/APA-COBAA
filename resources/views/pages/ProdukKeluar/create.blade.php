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
            <form action="{{ route('produkKeluar.store') }}" method="POST">
                @csrf
                <div class="mt-3">
                    <label for="kd_bahan" class="form-label font-medium"> Kode Produk </label>
                    <select name="kd_produk" class="form-select form-control @error('kd_produk') is-invalid @enderror" required autofocus onchange="changeValue(this.value)" onclick="changeValue(this.value)">
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
                <div class="mt-3">
                    <label for="nm_produk">Nama produk</label>
                    <input type="text" class="form-control" id="nm_produk" readonly>
                  </div>
                <div class=" mt-3">
                    <label for="stok" class="form-label font-medium"> Stok Bahan </label>
                    <div class="form-group input-group">
                    <input type="number" class="form-control" name="stok" id="stok" readonly>
                    <input type="text" class="form-control" id="nm_satuan" readonly>
                </div>
                <div class=" mt-3">
                    <label for="jumlah" class="form-label font-medium"> Jumlah </label>
                    <div class="form-group input-group">
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required>
                        <input type="text" class="form-control" id="nm_satuan2" readonly>
                        @error('jumlah')
                        <div class="col-12 text-danger mt-2 mx-1">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mt-3">
                    <label for="tgl_keluar" class="form-label font-medium"> Tanggal Keluar </label>
                    <input type="text" class="datepicker form-control @error('tgl_keluar') border-danger @enderror" data-single-mode="true" name="tgl_keluar" id="tgl_keluar" value="{{ old('tgl_keluar') }}">
                </div>
                @error('tgl_keluar')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                </div>
                <div class="mt-3">
                    <label for="ket" class="form-label font-medium"> Keterangan </label>
                    <textarea type="text" class="form-control @error('ket') is-invalid @enderror" name="ket" id="ket" placeholder="Masukkan Keterangan" required>{{ old('ket') }}</textarea>
          @error('ket')
          <div class="text-danger mt-2 mx-1">
            {{ $message }}
          </div>
          @enderror
        </div>
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
      document.getElementById('nm_produk').value = prdName[x].nm_produk;
      document.getElementById('stok').value = prdName[x].stok;
      document.getElementById('nm_satuan').value = prdName[x].nm_satuan;
      document.getElementById('nm_satuan2').value = prdName[x].nm_satuan2;
    }
  </script>
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection

@extends('../layout/' . $layout)

@section('subhead')
<title>Tambah Data Produk - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Tambah Data Produk </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form action="{{ route('produkJadi.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input name="stok" id="stok" type="text" class="form-control block w-full @error('stok') border-danger @enderror rounded-md border-gray-300 pl-3 pr-12 sm:text-sm" placeholder="Masukkan Stok" value="{{ old('stok') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select name="kd_satuan" id="satuan" class="form-control h-full rounded-md  @error('kd_satuan') border-danger @enderror border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 sm:text-sm">
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
                <div class="mt-5">
                    <label for="foto" class="form-label"> Foto </label>
                            <input type="file" id="foto" name="foto">
                        </label>
                    </div>
                </div>
                <div class="relative">
                    <div class="intro-y col-span-11 2xl:col-span-9">
                        <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                            <a href="/produkJadi" type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Cancel</a>
                            <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- <script>
const inputElement = document.querySelector('input[id="foto"]');

const pond = FilePond.create(inputElement);


FilePond.setOptions({
    server: {
        headers:{
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }
});
</script> --}}
<!-- menghilangkan id hilang ketika file di upload -->
<script>
    document.getElementById('dropzone-file').addEventListener('change', function() {
        document.getElementById('hilang').style.display = 'none';
    });
</script>
@endsection
@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>

<script>
   const inputElement = document.querySelector('input[id="foto"]');

const pond = FilePond.create(inputElement);


FilePond.setOptions({
    server: {
        process:'/tmp-upload',
        headers:{
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }
});
    </script>
@endsection

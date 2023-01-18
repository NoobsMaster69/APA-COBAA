@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Data Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Edit Data Bahan</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form class="" action="{{ route('dataBahan.update', $dataBahan->kd_bahan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <label for="kd_bahan" class="form-label"> Kode Bahan </label>
                    <input id="kd_bahan" name="kd_bahan" type="text" value="{{ $dataBahan->kd_bahan }}" readonly class="form-control w-full">
                </div>
                <div class="mt-5">
                    <label for="nm_bahan" class="form-label"> Nama Bahan </label>
                    <input name="nm_bahan" id="nm_bahan" type="text" class="form-control w-full @error('nm_bahan') border-danger @enderror" placeholder="Masukkan Nama Bahan" minlength="3" value="{{ old('nm_bahan', $dataBahan->nm_bahan) }}">
                    @error('nm_bahan')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="harga_beli" class="form-label"> Harga Beli </label>
                    <input name="harga_beli" id="harga_beli" type="number" class="form-control w-full @error('harga_beli') border-danger @enderror" placeholder="Masukkan Harga Beli" value="{{ old('harga_beli', $dataBahan->harga_beli)  }}">
                    @error('harga_beli')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mt-">
                    <label for="stok" class="form-label"> Stok </label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        </div>
                        <input name="stok" id="stok" type="number" class="form-control block w-full @error('stok') border-danger @enderror rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Stok" value="{{ old('stok', $dataBahan->stok) }}">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select name="kd_satuan" id="satuan" class="form-control h-full rounded-md  @error('kd_satuan') border-danger @enderror border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option disabled hidden selected>-- Pilih Satuan --</option>
                                @foreach ($satuan as $sat)
                                @if (old('kd_satuan', $dataBahan->kd_satuan) == $sat->id_satuan)
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
                </div>
                <div class="mt-5">
                    <label for="ket" class="form-label w-full flex flex-col sm:flex-row">
                        Keterangan
                    </label>
                    <textarea name="ket" id="ket" class="form-control @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan">{{ old('ket', $dataBahan->ket) }}</textarea>
                    @error('ket')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="text-right mt-8">
                    <a href="/databahan" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
    @endsection

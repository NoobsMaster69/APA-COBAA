@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Data Produk - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Edit Data Produk </h2>
</div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box px-10 py-5">
                <form action="{{ route('produkJadi.update', $produkJadi->kd_produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-3">
                        <label for="kd_produk" class="form-label">Kode Produk</label>
                        <input id="kd_produk" type="text" class="form-control w-full" name="kd_produk" value="{{ $produkJadi->kd_produk }}" readonly>
                    </div>
                    <div class="mt-3">
                        <label for="nm_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control w-full @error('nm_produk') border-danger @enderror" id="nm_produk" name="nm_produk" value="{{ old('nm_produk', $produkJadi->nm_produk) }}" required>
                        @error('nm_produk')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="stok" class="form-label"> Stok </label>
                        <div class="relative rounded-md shadow-sm">
                            <input name="stok" id="stok" type="number" class="form-control block w-full @error('stok') border-danger @enderror rounded-md border-gray-300 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('stok', $produkJadi->stok) }}">
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <select name="kd_satuan" id="kd_satuan" class="form-control h-full rounded-md  @error('kd_satuan') border-danger @enderror border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach ($satuan as $sat)
                                        @if (old('kd_satuan', $produkJadi->kd_satuan) == $produkJadi->kd_satuan)
                                            <option value="{{ $sat->id_satuan }}" selected>{{ $sat->nm_satuan }}</option>
                                        @else
                                            <option value="{{ $sat->id_satuan }}">{{ $sat->nm_satuan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('kd_satuan')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @error('stok')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control w-full @error('harga_jual') border-danger @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produkJadi->harga_jual) }}" required>
                        @error('harga_jual')
                            <div class="text-danger mt-2 mx-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                
                    <div class="mt-3">
                        <label for="ket" class="form-label">Keterangan</label>
                        <textarea class="form-control w-full @error('ket') border-danger @enderror" id="ket" name="ket" required>{{ old('ket', $produkJadi->ket) }}</textarea>
                        @error('ket')
                            <div class="text-danger mt-2 mx-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-5">
                        <label for="foto" class="form-label"> Foto </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-fit border-2 border-gray-50 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 @error('foto') border-danger @enderror">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <img src="{{ asset('images/'.$produkJadi->foto) }}" class="my-0 rounded-lg w-32" id="output">
                                    {{-- <div class="flex flex-col items-center justify-center pt-5 pb-6" id="hilang">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                    </div> --}}
                                </div>
    
                                <input id="dropzone-file" type="file" class="hidden" name="foto" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" />
    
                            </label>
                        </div>
                        @error('foto')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                        @enderror
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
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection
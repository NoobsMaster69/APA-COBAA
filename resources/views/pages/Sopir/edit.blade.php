@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Data Sopir - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Data Sopir</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form class="" action="{{ route('sopir.update', $sopir->kd_sopir) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <label for="kd_sopir" class="form-label"> Kode Sopir </label>
                    <input id="kd_sopir" name="kd_sopir" type="text" value="{{ $sopir->kd_sopir }}" readonly class="form-control w-full">
                </div>
                <div class="mt-5">
                    <label for="no_ktp" class="form-label"> Nomor KTP </label>
                    <input name="no_ktp" id="no_ktp" type="number" class="form-control w-full @error('no_ktp') border-danger @enderror" placeholder="Masukkan Nomor KTP" minlength="3" value="{{ old('no_ktp', $sopir->no_ktp) }}" required>
                    @error('no_ktp')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="nm_sopir" class="form-label"> Nama Sopir </label>
                    <input name="nm_sopir" id="nm_sopir" type="text" class="form-control w-full @error('nm_sopir') border-danger @enderror" placeholder="Masukkan Nama Sopir" value="{{ old('nm_sopir', $sopir->nm_sopir) }}" required>
                    @error('nm_sopir')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="jenis_kelamin" class="form-label"> Jenis Kelamin </label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select-md @error('jenis_kelamin') border-danger @enderror" required>
                        <option disabled hidden selected>-- Silahkan Pilih --</option>
                        @if (old('jenis_kelamin', $sopir->jenis_kelamin) == $sopir->jenis_kelamin)
                            <option value="{{ $sopir->jenis_kelamin }}" hidden selected>{{ $sopir->jenis_kelamin }}</option>
                        @else
                            <option value="{{ $sopir->jenis_kelamin }}" hidden selected>{{ $sopir->jenis_kelamin }}</option>
                        @endif
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="alamat" class="form-label">
                        Alamat
                    </label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') border-danger @enderror" placeholder="Masukkan Alamat" required>{{ old('alamat', $sopir->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="foto" class="form-label">
                        Foto
                    </label>
                    <input name="foto" id="foto" type="file" class="form-control w-full @error('foto') border-danger @enderror" value="{{ old('foto', $sopir->foto) }}" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                    <img src="{{ asset('images/'.$sopir->foto) }}" id="output">
                    @error('foto')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-right mt-8">
                    <a href="/tampilsopir" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection
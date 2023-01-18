@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Data Mobil - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Data Mobil</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form class="" action="{{ route('mobil.update', $mobil->kd_mobil) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <label for="kd_mobil" class="form-label"> Kode Mobil </label>
                    <input id="kd_mobil" name="kd_mobil" type="text" value="{{ $mobil->kd_mobil }}" readonly class="form-control w-full">
                </div>
                <div class="mt-5">
                    <label for="merk" class="form-label"> Merk Mobil </label>
                    <input name="merk" id="merk" type="text" class="form-control w-full @error('merk') border-danger @enderror" placeholder="Masukkan Merk Mobil" minlength="3" value="{{ old('merk', $mobil->merk) }}">
                    @error('merk')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="plat_nomor" class="form-label"> Nomor Polisi </label>
                    <input name="plat_nomor" id="plat_nomor" type="text" class="form-control w-full @error('plat_nomor') border-danger @enderror" placeholder="Masukkan Nomor Polisi" value="{{ old('plat_nomor', $mobil->plat_nomor) }}">
                    @error('plat_nomor')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <label for="ket" class="form-label w-full flex flex-col sm:flex-row">
                        Keterangan
                    </label>
                    <textarea name="ket" id="ket" class="form-control @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan">{{ old('ket', $mobil->ket) }}</textarea>
                    @error('ket')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-right mt-8">
                    <a href="/tampilmobil" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection
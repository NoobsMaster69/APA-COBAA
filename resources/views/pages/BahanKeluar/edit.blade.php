@extends('../layout/' . $layout)

@section('subhead')
<title>Edit Pemakaian Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Edit Pemakaian Bahan</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box px-10 py-5">
            <form action="{{ route('bahanKeluar.update', $bahanKeluar->id_bahanKeluar) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <label for="kd_bahan" class="form-l abel"> Kode Bahan </label>
                    <input type="hidden" name="kd_bahan" class="form-control" id="kd_bahan" value=" {{ $bahanKeluar->kd_bahan  }}">
                    <input type="text" class="form-control @error('kd_bahan') border-danger @enderror" required id="kd_bahan" value="{{ $bahanKeluar->kd_bahan . ' - ' . $bahanKeluar->nm_bahan  }}" readonly>
                </div>
                <div class="mt-5">
                    <label for="jumlah" class="form-label"> Jumlah Bahan </label>
                    <input type="number" class="form-control @error('jumlah') border-danger @enderror" name="jumlah" id="jumlah" value="{{ old('jumlah', $bahanKeluar->jumlah) }}" required>
                </div>
                @error('jumlah')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="mt-5">
                    <label for="tgl_keluar" class="form-label"> Tanggal Keluar </label>
                    <div class="relative w-100 mx-flex">
                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="tgl_keluar" id="tgl_keluar" class="datepicker form-control pl-12" data-single-mode="true" value="{{ old('tgl_keluar', $bahanKeluar->tgl_keluar) }}">
                    </div>
                </div>
                @error('tgl_keluar')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="mt-5">
                    <label for="ket" class="form-label w-full flex flex-col sm:flex-row">
                        Keterangan
                    </label>
                    <textarea name="ket" id="ket" class="form-control @error('ket') border-danger @enderror" placeholder="Masukkan Keterangan">{{ old('ket', $bahanKeluar->ket) }}</textarea>
                    @error('ket')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="text-right mt-8">
                    <a href="/bahanKeluar" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
    @endsection
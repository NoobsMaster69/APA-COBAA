@extends('../layout/' . $layout)

@section('subhead')
<title>Tambah Pembelian Bahan - Bread Smile</title>
@endsection

@section('subcontent')
<div class="intro-y box p-5 mt-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
            <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Informasi Pembelian Bahan
        </div>
        <form action="{{ route('bahanMasuk.store') }}" method="POST">
            @csrf
            <div class="mt-5">
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <label for="kd_satuan" class="font-medium">Kode Bahan </label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select name="kd_satuan" id="satuan" id="product-name" type="text" class="form-control" placeholder="Kode Bahan" required autofocus onchange="changeValue(this.value)">
                            <option value="0" hidden disabled selected>Pilih Kode Bahan</option>
                            @php
                            $jsArray = "var prdName = new Array();\n";
                            @endphp

                            @foreach ($dataBahan as $bahan)
                            <option value="{{ $bahan->kd_bahan }}">{{ $bahan->kd_bahan }} - {{ $bahan->nm_bahan }} </option>

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
                </div>
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <label for="nm_bahan " class="font-medium">Nama Bahan </label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <input type="text" class="form-control" name="nm_bahan" id="nm_bahan" readonly>
                    </div>
                </div>
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Harga Bahan </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <input type="text" class="form-control" id="harga_beliTampil" readonly>
                        <input type="hidden" class="form-control" name="harga_beli" id="harga_beli">
                    </div>
                </div>
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Stok Bahan </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <input id="stok" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Tanggal Masuk Bahan </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative w-full mt-3 xl:mt-0 flex-1">
                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                            <i data-feather="calendar" class="w-4 h-100"></i>
                        </div>
                        <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                    </div>
                </div>
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Keterangan </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <textarea name="ket" id="ket" class="form-control" placeholder="Type your comments" minlength="3"></textarea>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
<!-- END: Form Layout -->
<div class="grid justify-items-start hover:justify-items-center md:flex-row gap-2 mt-5">
    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Cancel</button>
    <button type="button" class="btn py-3 btn-primary w-full md:w-52">Save</button>
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

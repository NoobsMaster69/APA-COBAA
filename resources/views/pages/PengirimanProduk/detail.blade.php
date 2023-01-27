<div id="detail-{{ $produk->id_pengirimanProduk }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h3 class="font-medium text-base mr-auto">Detail Data</h3>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4">
                <div class="intro-y col-span-12 md:col-span-12 lg:col-span-12 border-2 border-slate-200/60 rounded-md shadow-lg shadow-slate-900">
                    <div class="box">
                        <div class="flex items-start px-5 pt-5 pb-5 border-b border-slate-400">
                            <div class="w-full flex flex-col lg:flex-row items-center">
                                <div class="w-20 h-20 rounded-lg overflow-hidden shadow-lg bg-no-repeat bg-local bg-top zoom-in scale-110">
                                    <img alt="Foto Produk" class="rounded-lg object-scale-down" src="{{ asset('images/'.$produk->foto) }}">
                                </div>
                                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="font-large font-semibold">{{ $produk->nm_produk }} ({{ $produk->jumlah }} {{ $produk->nm_satuan }})</a>
                                    <div class="text-slate-500 text-xs mt-0.5">{{ $produk->kd_produk }}</div>
                                </div>
                            </div>
                            <div class="absolute right-0 top-0 mr-5 mt-3 dropdown">
                                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                                    <i data-feather="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                                </a>
                                <div class="dropdown-menu w-40">
                                    <div class="dropdown-content">
                                        <a href="#" class="dropdown-item">
                                            <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center lg:text-left px-5 pb-5 pt-3">

                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-3">
                                <i data-feather="bell" class="w-3 h-3 mr-2"></i>
                                @if ($produk->status == 0)
                                <span class="text-warning">Menunggu Konfirmasi Anda</span>
                                @elseif ($produk->status == 1)
                                <span class="text-primary">Sedang Dikirim</span>
                                @elseif ($produk->status == 2)
                                <span class="text-success">Selesai</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-3">
                                <i data-feather="user" class="w-3 h-3 mr-2"></i> {{ $produk->nm_sopir }}
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-2">
                                <i data-feather="truck" class="w-3 h-3 mr-2"></i> {{ $produk->plat_nomor }}
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-2">
                                <!-- format tanggal pengiriman -->
                                <i data-feather="calendar" class="w-3 h-3 mr-2"></i> {{ date('d F Y',strtotime($produk->tgl_pengiriman)) }}
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-2">
                                <i data-feather="tool" class="w-3 h-3 mr-2"></i> {{ ucwords($produk->role) }}
                            </div>
                            {{-- <div class="border-t border-slate-500"></div> --}}
                            <div class="flex items-center justify-center lg:justify-start text-slate-700 mt-2">
                                <i data-feather="map-pin" class="w-3 h-3 mr-2"></i> Alamat
                            </div>
                            <div class="flex justify-center lg:justify-start text-slate-700 mt-2 pl-4">
                                {{ $produk->alamat }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mb-1">
                <button type="button" data-tw-dismiss="modal" class="btn btn-primary">Back</button>
            </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
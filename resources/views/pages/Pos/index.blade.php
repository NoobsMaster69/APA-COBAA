@extends('../layout/' . $layout)

@section('subhead')
<title>{{ $tittle }} - Bread Smile</title>
@endsection

@section('subcontent')
<div class="mt-10">
    <h2 class="text-lg font-medium mr-auto">{{ $judul }}</h2>
</div>
<div class="intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="lg:flex intro-y">
            <div class="relative">
                <input type="text" class="form-control py-3 px-4 w-full lg:w-64 box pr-10" placeholder="Search item...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-feather="search"></i>
            </div>
            <select class="form-select py-3 px-4 box w-full lg:w-auto mt-3 lg:mt-0 ml-auto">
                <option>Sort By</option>
                <option>A to Z</option>
                <option>Z to A</option>
                <option>Lowest Price</option>
                <option>Highest Price</option>
            </select>
        </div>
        {{-- <div class="grid grid-cols-12 gap-5 mt-5">
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Soup</div>
                <div class="text-slate-500">5 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box bg-primary p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base text-white">Pancake & Toast</div>
                <div class="text-white text-opacity-80 dark:text-slate-500">8 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Pasta</div>
                <div class="text-slate-500">4 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Waffle</div>
                <div class="text-slate-500">3 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Snacks</div>
                <div class="text-slate-500">8 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Deserts</div>
                <div class="text-slate-500">8 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Beverage</div>
                <div class="text-slate-500">9 Items</div>
            </div>
        </div> --}}

        {{-- display produk --}}
        <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t">
            @foreach ($produk as $p)
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#produk{{ $p->kd_produk }}" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3">
                    <div class="box rounded-md p-3 relative zoom-in">
                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                <img alt="Roti" class="rounded-md" src="{{ asset('images/'.$p->foto) }}">
                            </div>
                        </div>
                        <div class="block font-medium text-center truncate mt-3">{{ $p->nm_produk }}</div>
                        <div class="block font-medium text-center truncate mt-3">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        {{-- end display produk --}}

    </div>
    <!-- END: Item List -->

    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <ul class="nav nav-pills" role="tablist">
                    <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                        <button
                            class="nav-link w-full py-2 active"
                            data-tw-toggle="pill"
                            data-tw-target="#ticket"
                            type="button"
                            role="tab"
                            aria-controls="ticket"
                            aria-selected="true"
                        >
                            Orders
                        </button>
                    </li>
                    <li id="details-tab" class="nav-item flex-1" role="presentation">
                        <button
                            class="nav-link w-full py-2"
                            data-tw-toggle="pill"
                            data-tw-target="#details"
                            type="button"
                            role="tab"
                            aria-controls="details"
                            aria-selected="false"
                        >
                            Faktur
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">

                {{-- data order sementara --}}
                <div class="box p-2 mt-5">
                    <div class="flex mt-2 ml-1 pl-1 pb-2 border-b-2">
                        <div class="font-medium">Item</div>
                    </div>
                    @foreach ($temp as $tmp)
                        <div class="flex items-center p-3 transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 dark:hover:bg-darkmode-400 rounded-md">
                            <div class="max-w-[50%] truncate mr-1">{{ $tmp->nm_produk }}</div>
                            <div class="text-slate-500"><span class="bg-success text-white p-1 rounded text-xs">x{{ $tmp->jumlah }}</span></div>
                            <div class="ml-auto font-medium">Rp {{ number_format($tmp->harga, 0, ',', '.') }}</div>
                            <i data-feather="edit" class="w-4 h-4 text-primary ml-5 cursor-pointer" data-tw-toggle="modal" data-tw-target="#edit_temp{{ $tmp->id }}"></i>
                            <form action="{{ route('temp_delete',$tmp->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <span class="text-danger my-auto ml-2">x</span>
                                    {{-- <i data-feather="trash-2" class="w-4 h-4 text-danger ml-1"></i> --}}
                                </button>
                            </form>
                            
                        </div>
                    @endforeach
                    
                    @if (!empty($temp) || $temp == !null)
                    <form action="{{ route('temp_delete_all') }}" method="POST" class="flex mt-3 mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-warning mr-1 mb-2 ml-auto">
                            <i data-feather="refresh-cw" class="w-3 h-3"></i>
                        </button>
                    </form>
                    @endif

                </div>
                {{-- end data order sementara --}}

                {{-- form total harga --}}
                <form action="{{ route('order_create') }}" method="POST">
                    @csrf
                <div class="box p-5 mt-5">
                    <div class="flex">
                        <div class="mr-auto">Subtotal</div>
                        <div class="font-medium">Rp {{ number_format($sum, 0, ',', '.') }}</div>
                    </div>
                    @php
                        $pajak = $sum * 0.05;
                        $totalBayar = $pajak + $sum;
                    @endphp
                    <div class="flex mt-4">
                        <div class="mr-auto">Pajak</div>
                        <div class="font-medium">Rp {{ number_format($pajak, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="mr-auto font-medium text-base">Total</div>
                        <div class="font-medium text-base">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
                        <input type="hidden" name="total" value="{{ $totalBayar }}">
                    </div>

                    
                </div>
                <div class="box p-5 mt-5">
                    <input type="text" class="form-control w-full bg-slate-100 border-slate-200/60" name="bayar" placeholder="Bayar">
                </div>
                
                
                <div class="flex mt-5">
                    <button type="submit" class="btn btn-primary w-32 shadow-md ml-auto">Simpan</button>
                </form>
                </div>
                {{-- end form total harga --}}

            </div>

            {{-- data faktur pembelian --}}
            <div id="details" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                <div class="box p-5 mt-5">
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                        <div>
                            <div class="text-slate-500">Time</div>
                            <div class="mt-1">02/06/20 02:10 PM</div>
                        </div>
                        <i data-feather="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                        <div>
                            <div class="text-slate-500">Customer</div>
                            <div class="mt-1">{{ $fakers[0]['users'][0]['name'] }}</div>
                        </div>
                        <i data-feather="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                        <div>
                            <div class="text-slate-500">People</div>
                            <div class="mt-1">3</div>
                        </div>
                        <i data-feather="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center pt-5">
                        <div>
                            <div class="text-slate-500">Table</div>
                            <div class="mt-1">21</div>
                        </div>
                        <i data-feather="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                </div>
            </div>
            {{-- end data faktur pembelian --}}

        </div>
    </div>
    <!-- END: Ticket -->
</div>

<!-- BEGIN: New Order Modal -->
{{-- <div id="new-order-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">New Order</h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <label for="pos-form-1" class="form-label">Name</label>
                    <input id="pos-form-1" type="text" class="form-control flex-1" placeholder="Customer name">
                </div>
                <div class="col-span-12">
                    <label for="pos-form-2" class="form-label">Table</label>
                    <input id="pos-form-2" type="text" class="form-control flex-1" placeholder="Customer table">
                </div>
                <div class="col-span-12">
                    <label for="pos-form-3" class="form-label">Number of People</label>
                    <input id="pos-form-3" type="text" class="form-control flex-1" placeholder="People">
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                <button type="button" class="btn btn-primary w-32">Create Ticket</button>
            </div>
        </div>
    </div>
</div> --}}
<!-- END: New Order Modal -->

{{-- modal order produk --}}
@foreach ($produk as $prdk)
<div id="produk{{ $prdk->kd_produk }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">{{ $prdk->nm_produk }}</h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <form action="{{ route('temp_create') }}" method="POST">
                    @csrf
                    <div class="col-span-12">
                        <label for="pos-form-4" class="form-label">Jumlah</label>
                        <div class="flex mt-2 flex-1">
                            <button type="button" id="kurang" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1">-</button>
                            <input id="jumlah" type="number" name="jumlah" class="form-control w-24 text-center" placeholder="Item quantity" min="1" value="1">
                            <button type="button" id="tambah" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1">+</button>
                        </div>
                        <input type="hidden" name="kd_produk" value="{{ $prdk->kd_produk }}">
                    </div>
                
                {{-- <div class="col-span-12">
                    <label for="pos-form-5" class="form-label">Notes</label>
                    <textarea id="pos-form-5" class="form-control w-full mt-2" placeholder="Item notes"></textarea>
                </div> --}}
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-24">Add Item</button>
            </form>
            </div>
        </div>
    </div>
</div> 
@endforeach

{{-- modal edit temp --}}
@foreach ($temp as $tmp)
<div id="edit_temp{{ $tmp->id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">{{ $tmp->nm_produk }}</h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <form action="{{ route('temp_update',$tmp->id) }}" method="POST">
                    @csrf
                    <div class="col-span-12">
                        <label for="pos-form-4" class="form-label">Jumlah</label>
                        <div class="flex mt-2 flex-1">
                            <button type="button" id="kurang" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1">-</button>
                            <input id="jumlah" type="number" name="jumlah" class="form-control w-24 text-center" placeholder="Item quantity" min='1' value="{{ $tmp->jumlah }}">
                            <button type="button" id="tambah" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1">+</button>
                        </div>
                    </div>
                    <input type="hidden" name="kd_produk" value="{{ $tmp->produk_id }}">

                
                {{-- <div class="col-span-12">
                    <label for="pos-form-5" class="form-label">Notes</label>
                    <textarea id="pos-form-5" class="form-control w-full mt-2" placeholder="Item notes"></textarea>
                </div> --}}
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-24">Add Item</button>
            </form>
            </div>
        </div>
    </div>
</div> 
@endforeach


{{-- <script>
    function add(){
    var subTotal,total; //membuat variabel
    document.getElementById("tambah").onclick = function() {tambahValue()};

    function tambahValue() {
        a=Number(document.getElementById("jumlah").value); //menangkap input angka pertama
        total = a + 1; //melakukan penjumlahan
        document.getElementById("jumlah").value= total;
    }
    
}
</script>

<script>
    function total() {
    var harga =  parseInt(document.getElementById('harga_barang').value);
    var jumlah_beli =  parseInt(document.getElementById('quantity').value);
    var jumlah_harga = harga * jumlah_beli;
        document.getElementById('subtotal').value = jumlah_harga;
  }
</script> --}}

@endsection
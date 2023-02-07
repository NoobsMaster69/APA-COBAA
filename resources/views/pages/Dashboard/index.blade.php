@extends('../layout/' . $layout)

@section('subhead')
<title>Dashboard - Icewall - Tailwind HTML Admin Template</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Data Keseluruhan</h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    <a href="/karyawan" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success cursor-pointer">
                                            <span class="pr-1">Data</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $karyawan }}</div>
                                <div class="text-base text-slate-500 mt-1">Karyawan</div>
                            </div>
                        </div>
                    </a>
                    <a href="/pengirimanProduk" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="truck" class="report-box__icon text-pending"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success cursor-pointer">
                                                <span class="pr-1">Data</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $pengirimanProduk }}</div>
                                    <div class="text-base text-slate-500 mt-1">Pengiriman</div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="/produkJadi" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="package" class="report-box__icon text-warning"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success cursor-pointer">
                                                <span class="pr-1">Data</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $produkJadi }}</div>
                                    <div class="text-base text-slate-500 mt-1">Jenis Roti</div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="/dataBahan" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="box" class="report-box__icon text-success"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success cursor-pointer">
                                                <span class="pr-1">Data</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $dataBahan }}</div>
                                    <div class="text-base text-slate-500 mt-1">Bahan-bahan</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 lg:col-span-6 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Laporan Produk</h2>
                    <!-- <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                        <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                        <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                    </div> -->
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col xl:flex-row xl:items-center mb-6">
                        <div class="flex">
                            <div>
                                <!-- menampilkan dalam bentuk rupiah $produkKeluar_lap_bulanIni -->
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">Rp. {{ number_format($produkKeluar_lap_bulanIni, 0, ',', '.') }}</div>
                                <div class="mt-0.5 text-slate-500">Penjualan Produk Bulan ini</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                <div class="text-warning text-lg xl:text-xl font-medium">Rp. {{ number_format($produkMasuk_lap_bulanIni, 0, ',', '.') }}</div>
                                <div class="mt-0.5 text-slate-500">Pembuatan Produk Bulan ini</div>
                            </div>
                        </div>
                        <!-- <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                            <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                                Filter by Category <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content overflow-y-auto h-32">
                                    <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                    <li><a href="" class="dropdown-item">Smartphone</a></li>
                                    <li><a href="" class="dropdown-item">Electronic</a></li>
                                    <li><a href="" class="dropdown-item">Photography</a></li>
                                    <li><a href="" class="dropdown-item">Sport</a></li>
                                </ul>
                            </div>
                        </div> -->
                    </div>
                    <div>
                        <canvas id="lineChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Sales Report -->
            <!-- BEGIN: Weekly Top Seller -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Roti Terlaris</h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="pieChart" height="300"></canvas>
                </div>
            </div>
            <!-- END: Weekly Top Seller -->
            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Outlet Terlaris</h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="doughnutChart" height="300"></canvas>
                </div>
            </div>
            <!-- END: Sales Report -->
            <!-- BEGIN: Official Store -->
            <div class="col-span-12 xl:col-span-6 mt-6">
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y mt-10">
                    <div class="box p-5 zoom-in">
                        <div class="flex items-center">
                            <div class="w-2/4 flex-none">
                                <div class="text-lg font-medium truncate">Keuntungan</div>
                                <div class="text-slate-500 mt-1">Rp. 100.000.000</div>
                            </div>
                            <div class="flex-none ml-auto relative">
                                <img src="{{ asset('dist/images/profits.png') }}" alt="" width="90">
                                <div class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">20%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y mt-4">
                    <div class="box p-5 zoom-in">
                        <div class="flex items-center">
                            <div class="w-2/4 flex-none">
                                <div class="text-lg font-medium truncate">Produk Terjual</div>
                                <div class="text-slate-500 mt-1">1450 Roti</div>
                            </div>
                            <div class="flex-none ml-auto relative">
                                <canvas id="report-donut-chart-2" width="90" height="90"></canvas>
                                <div class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">45%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Official Store -->
            <!-- BEGIN: Weekly Best Sellers -->
            <div class="col-span-12 xl:col-span-6 mt-4">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Sopir Terbaik Bulan ini</h2>
                </div>
                <div class="mt-5">
                    @foreach (array_slice($fakers, 0, 4) as $faker)
                    <div class="intro-y">
                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                <img alt="Icewall Tailwind HTML Admin Template" src="{{ asset('dist/images/' . $faker['photos'][0]) }}">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">{{ $faker['users'][0]['name'] }}</div>
                                <div class="text-slate-500 text-xs mt-0.5">{{ $faker['dates'][0] }}</div>
                            </div>
                            <div class="py-1 px-2 rounded-full text-xs bg-success text-white cursor-pointer font-medium">137 Sales</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // produkMasuk
    let labelsMasuk = @json($labelsMasuk);
    let jumlahMasuk = @json($jumlahMasuk);
    // produkKeluar
    let labels = @json($labels);
    let jumlah = @json($jumlah);


    let ctx = document.getElementById("lineChart");
    let myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: "Penjualan Produk",
                    lineTension: 0.5,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: jumlah,
                },
                {
                    label: "Pembuatan Produk",
                    lineTension: 0.5,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(255,165,0,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,165,0,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(255,165,0,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: jumlahMasuk,
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        // max: 40000,
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                    }
                }],
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    align: 'start',
                }
            },
            responsive: true,
        }
    });

    let pctx = document.getElementById('pieChart');
    let myPieChart = new Chart(pctx, {
        type: 'pie',
        data: {
            labels: [
                'Roti Abon',
                'Roti keju',
                'Roti Coklat'
            ],
            datasets: [{
                label: 'Jumlah Roti Terjual',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }],
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    align: 'start',
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    let dctx = document.getElementById('doughnutChart');
    let myDoughnutChart = new Chart(dctx, {
        type: 'doughnut',
        data: {
            labels: [
                'CSB Mall',
                'ASIA Toserba',
                'Garasi Cafe'
            ],
            datasets: [{
                label: 'Omset Penjualan',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }],
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    align: 'start',
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>



@endsection
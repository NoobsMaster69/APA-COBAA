@extends('../layout/main')

@section('head')
@yield('subhead')
@endsection

@section('content')
@include('../layout/components/mobile-menu')
@include('../layout/components/top-bar')
@include('sweetalert::alert')

<div class="wrapper">
    <div class="wrapper-box">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <ul>
                <li>
                    <a href="/dashboard" class="side-menu {{ Request::is('/') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="home"></i>
                        </div>
                        <div class="side-menu__title">
                            Dashboard
                        </div>
                    </a>
                </li>

                <li class="side-nav__devider my-6"></li>

                @can('backoffice')

                <li>
                    <a href="/jabatan" class="side-menu {{ Request::is('jabatan*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="award"></i>
                        </div>
                        <div class="side-menu__title">
                            Jabatan
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/karyawan" class="side-menu {{ Request::is('karyawan*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="users"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Karyawan
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="side-menu {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="box"></i>
                        </div>
                        <div class="side-menu__title">
                            Bahan Baku
                            <div class="side-menu__sub-icon {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'transform rotate-180' : '' }}">
                                <i data-feather="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class=" {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'side-menu__sub-open' : '' }}">
                        <li>
                            <a href="/dataBahan" class="side-menu {{ Request::is('dataBahan*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="box"></i>
                                </div>
                                <div class="side-menu__title">
                                    Data Bahan
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/bahanMasuk" class="side-menu {{ Request::is('bahanMasuk*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="box"></i>
                                </div>
                                <div class="side-menu__title">
                                    Pembelian Bahan
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/bahanKeluar" class="side-menu {{ Request::is('bahanKeluar*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="box"></i>
                                </div>
                                <div class="side-menu__title">
                                    Pemakaian Bahan
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="package"></i>
                        </div>
                        <div class="side-menu__title">
                            Produk
                            <div class="side-menu__sub-icon {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'transform rotate-180' : '' }}">
                                <i data-feather="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class=" {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'side-menu__sub-open' : '' }}">
                        <li>
                            <a href="/resep" class="side-menu {{ Request::is('resep*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="package"></i>
                                </div>
                                <div class="side-menu__title">
                                    Data Resep
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/produkJadi" class="side-menu {{ Request::is('produkJadi*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="package"></i>
                                </div>
                                <div class="side-menu__title">
                                    Data Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/produkMasuk" class="side-menu {{ Request::is('produkMasuk*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="package"></i>
                                </div>
                                <div class="side-menu__title">
                                    Pembuatan Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/produkKeluar" class="side-menu {{ Request::is('produkKeluar*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="package"></i>
                                </div>
                                <div class="side-menu__title">
                                    Penjualan Produk
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="side-menu__title">
                            Pengiriman
                            <div class="side-menu__sub-icon {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'transform rotate-180' : '' }}">
                                <i data-feather="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class=" {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'side-menu__sub-open' : '' }}">
                        <li>
                            <a href="/pengirimanProduk" class="side-menu {{ Request::is('pengirimanProduk*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="truck"></i>
                                </div>
                                <div class="side-menu__title">
                                    Pengiriman Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/lokasiPengiriman" class="side-menu {{ Request::is('lokasiPengiriman*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="truck"></i>
                                </div>
                                <div class="side-menu__title">
                                    Lokasi Pengiriman
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/sopir" class="side-menu {{ Request::is('sopir*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="truck"></i>
                                </div>
                                <div class="side-menu__title">
                                    Data Sopir
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/mobil" class="side-menu {{ Request::is('mobil*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="truck"></i>
                                </div>
                                <div class="side-menu__title">
                                    Data Mobil
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ Request::is('') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="clipboard"></i>
                        </div>
                        <div class="side-menu__title">
                            Laporan
                            <div class="side-menu__sub-icon {{ Request::is('') ? 'transform rotate-180' : '' }}">
                                <i data-feather="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class=" {{ Request::is('') ? 'side-menu__sub-open' : '' }}">
                        <li>
                            <a href="#" class="side-menu {{ Request::is('*') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="clipboard"></i>
                                </div>
                                <div class="side-menu__title">
                                    Laporan Permintaan Bahan
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="side-menu {{ Request::is('') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="clipboard"></i>
                                </div>
                                <div class="side-menu__title">
                                    Laporan Permintaan Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="side-menu {{ Request::is('') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="clipboard"></i>
                                </div>
                                <div class="side-menu__title">
                                    Laporan Pengiriman Produk
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>


                @foreach ($side_menu as $menuKey => $menu)
                @if ($menu == 'devider')
                <li class="side-nav__devider my-6"></li>
                @else
                <li>
                    <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                        <div class="side-menu__icon">
                            <i data-feather="{{ $menu['icon'] }}"></i>
                        </div>
                        <div class="side-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                            <div class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                                <i data-feather="chevron-down"></i>
                            </div>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                    <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                        @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                        <li>
                            <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="activity"></i>
                                </div>
                                <div class="side-menu__title">
                                    {{ $subMenu['title'] }}
                                    @if (isset($subMenu['sub_menu']))
                                    <div class="side-menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @if (isset($subMenu['sub_menu']))
                            <ul class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                <li>
                                    <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                        <div class="side-menu__icon">
                                            <i data-feather="zap"></i>
                                        </div>
                                        <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
                @endforeach

                @endcan

                @can('gudang')

                <li>
                    <a href="/dataBahan" class="side-menu {{ Request::is('dataBahan*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Bahan
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/bahanMasuk" class="side-menu {{ Request::is('bahanMasuk*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Pembelian Bahan
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/bahanKeluar" class="side-menu {{ Request::is('bahanKeluar*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Pemakaian Bahan
                        </div>
                    </a>
                </li>

                @endcan

                @can('produksi')

                <li>
                    <a href="/resep" class="side-menu {{ Request::is('resep*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Resep
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/produkJadi" class="side-menu {{ Request::is('produkJadi*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Produk
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/produkMasuk" class="side-menu {{ Request::is('produkMasuk*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Pembuatan Produk
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/produkKeluar" class="side-menu {{ Request::is('produkKeluar*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Penjualan Produk
                        </div>
                    </a>
                </li>

                @endcan

                @can('distribusi')

                <li>
                    <a href="/produkJadi" class="side-menu {{ Request::is('produkJadi*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="clipboard"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Produk
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/pengirimanProduk" class="side-menu {{ Request::is('pengirimanProduk*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="side-menu__title">
                            Pengiriman Produk
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/lokasiPengiriman" class="side-menu {{ Request::is('lokasiPengiriman*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="side-menu__title">
                            Lokasi Pengiriman
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/sopir" class="side-menu {{ Request::is('sopir*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="clipboard"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Sopir
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/mobil" class="side-menu {{ Request::is('mobil*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="clipboard"></i>
                        </div>
                        <div class="side-menu__title">
                            Data Mobil
                        </div>
                    </a>
                </li>

                @endcan

                @can('sopir')
                <li>
                    <a href="/pengirimanProduk" class="side-menu {{ Request::is('pengirimanProduk*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="side-menu__title">
                            Pengiriman Produk
                        </div>
                    </a>
                </li>
                @endcan

                @can('kasir')
                <li>
                    <a href="/produkJadi" class="side-menu {{ Request::is('produkJadi*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            Produk
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/pos" class="side-menu {{ Request::is('pos*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i data-feather="inbox"></i>
                        </div>
                        <div class="side-menu__title">
                            POS System
                        </div>
                    </a>
                </li>
                @endcan

            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
</div>
@endsection

<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler">
            <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <ul class="border-t border-white/[0.08] py-5 hidden">

        <li>
            <a href="/" class="menu {{ Request::is('/') ? 'menu--active' : '' }}">
                <div class="menu__icon">
                    <i data-feather="home"></i>
                </div>
                <div class="menu__title">
                    Dashboard
                </div>
            </a>
        </li>

        <li class="nav__devider my-6"></li>

        @can('backoffice')

            <li>
                <a href="/jabatan" class="menu {{ Request::is('jabatan*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="award"></i>
                    </div>
                    <div class="menu__title">
                        Jabatan
                    </div>
                </a>
            </li>

            <li>
                <a href="/karyawan" class="menu {{ Request::is('karyawan*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="users"></i>
                    </div>
                    <div class="menu__title">
                        Data Karyawan
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="menu {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="box"></i>
                    </div>
                    <div class="menu__title">
                        Bahan Baku
                        <div class="menu__sub-icon {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class=" {{ Request::is('dataBahan*', 'bahanMasuk*', 'bahanKeluar*') ? 'menu__sub-open' : '' }}">
                    <li>
                        <a href="/dataBahan" class="menu {{ Request::is('dataBahan*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="box"></i>
                            </div>
                            <div class="menu__title">
                                Data Bahan
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/bahanMasuk" class="menu {{ Request::is('bahanMasuk*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="box"></i>
                            </div>
                            <div class="menu__title">
                                Pembelian Bahan
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/bahanKeluar" class="menu {{ Request::is('bahanKeluar*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="box"></i>
                            </div>
                            <div class="menu__title">
                                Pemakaian Bahan
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="menu {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="package"></i>
                    </div>
                    <div class="menu__title">
                        Produk
                        <div class="menu__sub-icon {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class=" {{ Request::is('resep*', 'produkJadi*', 'produkMasuk*', 'produkKeluar*') ? 'menu__sub-open' : '' }}">
                    <li>
                        <a href="/resep" class="menu {{ Request::is('resep*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="package"></i>
                            </div>
                            <div class="menu__title">
                                Data Resep
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/produkJadi" class="menu {{ Request::is('produkJadi*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="package"></i>
                            </div>
                            <div class="menu__title">
                                Data Produk
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/produkMasuk" class="menu {{ Request::is('produkMasuk*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="package"></i>
                            </div>
                            <div class="menu__title">
                                Pembuatan Produk
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/produkKeluar" class="menu {{ Request::is('produkKeluar*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="package"></i>
                            </div>
                            <div class="menu__title">
                                Penjualan Produk
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="menu {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="truck"></i>
                    </div>
                    <div class="menu__title">
                        Pengiriman
                        <div class="menu__sub-icon {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class=" {{ Request::is('pengirimanProduk*', 'terkirimProduk*' , 'sopir*', 'mobil*') ? 'menu__sub-open' : '' }}">
                    <li>
                        <a href="/pengirimanProduk" class="menu {{ Request::is('pengirimanProduk*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="truck"></i>
                            </div>
                            <div class="menu__title">
                                Pengiriman Produk
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/lokasiPengiriman" class="menu {{ Request::is('lokasiPengiriman*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="truck"></i>
                            </div>
                            <div class="menu__title">
                                Lokasi Pengiriman
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/sopir" class="menu {{ Request::is('sopir*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="truck"></i>
                            </div>
                            <div class="menu__title">
                                Data Sopir
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/mobil" class="menu {{ Request::is('mobil*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="truck"></i>
                            </div>
                            <div class="menu__title">
                                Data Mobil
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="menu {{ Request::is('') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="clipboard"></i>
                    </div>
                    <div class="menu__title">
                        Laporan
                        <div class="menu__sub-icon {{ Request::is('') ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class=" {{ Request::is('') ? 'menu__sub-open' : '' }}">
                    <li>
                        <a href="#" class="menu {{ Request::is('*') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="clipboard"></i>
                            </div>
                            <div class="menu__title">
                                Laporan Permintaan Bahan
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu {{ Request::is('') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="clipboard"></i>
                            </div>
                            <div class="menu__title">
                                Laporan Permintaan Produk
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu {{ Request::is('') ? 'menu--active' : '' }}">
                            <div class="menu__icon">
                                <i data-feather="clipboard"></i>
                            </div>
                            <div class="menu__title">
                                Laporan Pengiriman Produk
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            @foreach ($side_menu as $menuKey => $menu)
                @if ($menu == 'devider')
                    <li class="menu__devider my-6"></li>
                @else
                    <li>
                        <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'menu menu--active' : 'menu' }}">
                            <div class="menu__icon">
                                <i data-feather="{{ $menu['icon'] }}"></i>
                            </div>
                            <div class="menu__title">
                                {{ $menu['title'] }}
                                @if (isset($menu['sub_menu']))
                                    <i data-feather="chevron-down" class="menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}"></i>
                                @endif
                            </div>
                        </a>
                        @if (isset($menu['sub_menu']))
                            <ul class="{{ $first_level_active_index == $menuKey ? 'menu__sub-open' : '' }}">
                                @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                    <li>
                                        <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $second_level_active_index == $subMenuKey ? 'menu menu--active' : 'menu' }}">
                                            <div class="menu__icon">
                                                <i data-feather="activity"></i>
                                            </div>
                                            <div class="menu__title">
                                                {{ $subMenu['title'] }}
                                                @if (isset($subMenu['sub_menu']))
                                                    <i data-feather="chevron-down" class="menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}"></i>
                                                @endif
                                            </div>
                                        </a>
                                        @if (isset($subMenu['sub_menu']))
                                            <ul class="{{ $second_level_active_index == $subMenuKey ? 'menu__sub-open' : '' }}">
                                                @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                    <li>
                                                        <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $third_level_active_index == $lastSubMenuKey ? 'menu menu--active' : 'menu' }}">
                                                            <div class="menu__icon">
                                                                <i data-feather="zap"></i>
                                                            </div>
                                                            <div class="menu__title">{{ $lastSubMenu['title'] }}</div>
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
                <a href="/dataBahan" class="menu {{ Request::is('dataBahan*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Data Bahan
                    </div>
                </a>
            </li>

            <li>
                <a href="/bahanMasuk" class="menu {{ Request::is('bahanMasuk*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Pembelian Bahan
                    </div>
                </a>
            </li>

            <li>
                <a href="/bahanKeluar" class="menu {{ Request::is('bahanKeluar*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Pemakaian Bahan
                    </div>
                </a>
            </li>

        @endcan

        @can('produksi')

            <li>
                <a href="/resep" class="menu {{ Request::is('resep*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Data Resep
                    </div>
                </a>
            </li>

            <li>
                <a href="/produkJadi" class="menu {{ Request::is('produkJadi*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Data Produk
                    </div>
                </a>
            </li>

            <li>
                <a href="/produkMasuk" class="menu {{ Request::is('produkMasuk*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Pembuatan Produk
                    </div>
                </a>
            </li>

            <li>
                <a href="/produkKeluar" class="menu {{ Request::is('produkKeluar*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="inbox"></i>
                    </div>
                    <div class="menu__title">
                        Penjualan Produk
                    </div>
                </a>
            </li>

        @endcan

        @can('distribusi')

            <li>
                <a href="/produkJadi" class="menu {{ Request::is('produkJadi*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="clipboard"></i>
                    </div>
                    <div class="menu__title">
                        Data Produk
                    </div>
                </a>
            </li>

            <li>
                <a href="/pengirimanProduk" class="menu {{ Request::is('pengirimanProduk*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="truck"></i>
                    </div>
                    <div class="menu__title">
                        Pengiriman Produk
                    </div>
                </a>
            </li>

            <li>
                <a href="/lokasiPengiriman" class="menu {{ Request::is('lokasiPengiriman*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="truck"></i>
                    </div>
                    <div class="menu__title">
                        Lokasi Pengiriman
                    </div>
                </a>
            </li>

            <li>
                <a href="/sopir" class="menu {{ Request::is('sopir*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="clipboard"></i>
                    </div>
                    <div class="menu__title">
                        Data Sopir
                    </div>
                </a>
            </li>

            <li>
                <a href="/mobil" class="menu {{ Request::is('mobil*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="clipboard"></i>
                    </div>
                    <div class="menu__title">
                        Data Mobil
                    </div>
                </a>
            </li>

        @endcan

        @can('sopir')

            <li>
                <a href="/pengirimanProduk" class="menu {{ Request::is('pengirimanProduk*') ? 'menu--active' : '' }}">
                    <div class="menu__icon">
                        <i data-feather="truck"></i>
                    </div>
                    <div class="menu__title">
                        Pengiriman Produk
                    </div>
                </a>
            </li>

        @endcan
        
    </ul>
</div>
<!-- END: Mobile Menu -->

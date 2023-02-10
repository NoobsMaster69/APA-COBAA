<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bread Smile</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="assets/css/main.css?v=5.6" />
</head>

<body>
    <!-- Quick view -->

    <header class="header-area header-style-1 header-style-5 header-height-2">
        <!-- <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="page-about.htlm">About Us</a></li>
                                <li><a href="page-account.html">My Account</a></li>
                                <li><a href="shop-wishlist.html">Wishlist</a></li>
                                <li><a href="shop-order.html">Order Tracking</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="header-middle header-middle-ptb-2 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="index.html"><img src="assets/imgs/theme/logo.png" alt="logo" /></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-1">
                            <form action="">
                                <input type="text" name="search" autocomplete="off" value="{{ request('search') }}" placeholder="Search for items..." />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="">
                    <div class="logo logo-width-2 d-block d-lg-none">
                        <a href="index.html"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex justify-content-center">
                        <div class="main-categori-wrap d-none d-lg-block">
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li>
                                        <a class="active" href="/#home">Home</a>
                                    </li>
                                    <li>
                                        <a class="active" href="/#produk">Produk</a>
                                    </li>
                                    <li>
                                        <a href="#about">About</a>
                                    </li>

                                    <li>
                                        <a href="/login">Login</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="index.html"><img src="assets/imgs/theme/logo.png" alt="logo" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="menu-item-has-children">
                                <a href="/">Home</a>
                                <ul class="dropdown">
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="shop-grid-right.html">shop</a>
                                <ul class="dropdown">
                                    <li><a href="shop-grid-right.html">Shop Grid – Right Sidebar</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Product – Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop-filter.html">Shop – Filter</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Shop Invoice</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-invoice-1.html">Shop Invoice 1</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Vendors</a>
                                <ul class="dropdown">
                                    <li><a href="vendors-grid.html">Vendors Grid</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap">
                    <div class="single-mobile-header-info">
                        <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="page-login.html"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Follow Us</h6>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
                </div>
                <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
            </div>
        </div>
    </div>
    <!--End header-->
<main class="main pages">
    <div class="page-content pt-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <section class="row align-items-center mb-50">
                        <div class="col-lg-6">
                            <img src="dist/images/breadsmile.jpg" alt="" class="border-radius-15 mb-md-3 mb-lg-0 mb-sm-4" />
                        </div>
                        <div class="col-lg-6">
                            <div class="pl-25">
                                <h2 class="mb-30">Tentang Bread Smile</h2>
                                <p class="mb-25">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate id est laborum.</p>
                                <p class="mb-50">Ius ferri velit sanctus cu, sed at soleat accusata. Dictas prompta et Ut placerat legendos interpre.Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante Etiam sit amet orci eget. Quis commodo odio aenean sed adipiscing. Turpis massa tincidunt dui ut ornare lectus. Auctor elit sed vulputate mi sit amet. Commodo consequat. Duis aute irure dolor in reprehenderit in voluptate id est laborum.</p>
                                <div class="carausel-3-columns-cover position-relative">
                                    <div id="carausel-3-columns-arrows"></div>
                                    <div class="carausel-3-columns" id="carausel-3-columns">
                                        <img src="assets/imgs/page/about-2.png" alt="" />
                                        <img src="assets/imgs/page/about-3.png" alt="" />
                                        <img src="assets/imgs/page/about-4.png" alt="" />
                                        <img src="assets/imgs/page/about-2.png" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="about"class="text-center mb-50">
                        <h2 class="title style-3 mb-40">Dimana Saja Cabang Kami? </h2>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">

                                    <img src="" alt="Logo Cabang"/>
                                    <h4>Surya Toserba</h4>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.454613416763!2d108.56054321283447!3d-6.714243095145936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee38b3a27354f%3A0x937dad68f87102c6!2sBread%20Smile%20Surya%20Toserba!5e0!3m2!1sen!2sid!4v1676017051351!5m2!1sen!2sid" width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="" alt="Logo Cabang" />
                                    <h4>Csb Mall   </h4>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.4181838659347!2d108.5454938269531!3d-6.718716099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1dee5555555f%3A0x99edf0a988892f8f!2sHypermart%20-%20Cirebon%20Superblock%20Mall!5e0!3m2!1sen!2sid!4v1676017753455!5m2!1sen!2sid" width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="" alt="Logo Cabang" />
                                    <h4>Asia Toserba  </h4>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.4520039677063!2d108.56064131283456!3d-6.714563595145702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee26460ef2ce9%3A0x1c6d620051b9c96!2sAsia%20Toserba!5e0!3m2!1sen!2sid!4v1676017870222!5m2!1sen!2sid" width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="assets/imgs/theme/icons/icon-4.svg" alt="" />
                                    <h4>Easy Returns</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="assets/imgs/theme/icons/icon-5.svg" alt="" />
                                    <h4>100% Satisfaction</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="assets/imgs/theme/icons/icon-6.svg" alt="" />
                                    <h4>Great Daily Deal</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

    </div>
</main>
<section class="section-padding footer-mid flex justify-content-center">
    <div class="container pt-15 pb-20">
        <div class="row">
            <div class="col-12">
            </div>
            <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
            </div>
        </div>
    </div>
</section>
<div class="container pb-30 wow animate__animated animate__fadeInUp" data-wow-delay="0">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <p class="font-sm mb-0">&copy; 2022, <strong class="text-brand">Bread Smile</strong> - Toko Roti <br />All rights reserved</p>
            </div>
            <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex mr-30">
                    <img src="assets/imgs/theme/icons/phone-call.svg" alt="hotline" />
                    <p> +62 877-6924-6969<span>Info Pemesanan</span></p>
                </div>
            </div>

        </div>
    </div>
</footer>
<!-- Vendor JS-->
<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
<script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins/slick.js"></script>
<script src="assets/js/plugins/waypoints.js"></script>
<script src="assets/js/plugins/wow.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.js"></script>
<script src="assets/js/plugins/magnific-popup.js"></script>
<script src="assets/js/plugins/select2.min.js"></script>
<script src="assets/js/plugins/counterup.js"></script>
<script src="assets/js/plugins/jquery.countdown.min.js"></script>
<script src="assets/js/plugins/images-loaded.js"></script>
<script src="assets/js/plugins/scrollup.js"></script>
<script src="assets/js/plugins/jquery.vticker-min.js"></script>
<!-- Template  JS -->
<script src="assets/js/main.js?v=5.6"></script>

</body>

</html>

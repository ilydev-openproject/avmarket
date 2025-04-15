<!-- header-area-start -->
<header>
    <div id="header-sticky" class="header__main-area d-none d-xl-block">
        <div class="container">
            <div class="header__for-megamenu p-relative">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <div class="header__logo">
                            <a href="/"><img src="{{ asset('image/logo/logo.png') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="header__menu main-menu text-center">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="has-homemenu">
                                        <a href="/">Beranda</a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="/toko">Toko</a>
                                        <ul class="sub-menu">
                                            @php
                                            use App\Models\Kategori;
                                            use App\Models\Product;

                                            $kategori = Kategori::with('product')->get();
                                            @endphp
                                            @foreach ($kategori as $kat)
                                            <li><a href="/toko/{{ $kat->slug }}">{{ ucfirst($kat->nama_kategori) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class=" has-dropdown">
                                        <a href="blog.html">Blog</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog.html">Big image</a></li>
                                            <li><a href="blog-right-sidebar.html">Right sidebar</a></li>
                                            <li><a href="blog-left-sidebar.html">Left sidebar</a></li>
                                            <li><a href="blog-details.html">Single Post</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="about.html">Pages</a>
                                        <ul class="sub-menu">
                                            <li><a href="shop-location.html">Shop Location One</a></li>
                                            <li><a href="shop-location-2.html">Shop Location Two</a></li>
                                            <li><a href="faq.html">FAQs</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="cart.html">Cart Page</a></li>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                            <li><a href="log-in.html">Sign In</a></li>
                                            <li><a href="comming-soon.html">Coming soon</a></li>
                                            <li><a href="404.html">Page 404</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="header__info d-flex align-items-center">
                            <div class="header__info-search tpcolor__purple ml-10">
                                <button class="tp-search-toggle"><i class="icon-search"></i></button>
                            </div>
                            <div class="header__info-user tpcolor__yellow ml-10">
                                <a href="log-in.html"><i class="icon-user"></i></a>
                            </div>

                            <livewire:favorite-counter />
                            <div class="header__info-cart tpcolor__oasis ml-10 tp-cart-toggle">
                                <button><i><img src="{{ asset('orfarm/assets/img/icon/cart-1.svg') }}" alt=""></i>
                                    <span>5</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header-search -->
    <div class="tpsearchbar tp-sidebar-area">
        <button class="tpsearchbar__close"><i class="icon-x"></i></button>
        <div class="search-wrap text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6 pt-100 pb-100">
                        <h2 class="tpsearchbar__title">What Are You Looking For?</h2>
                        <div class="tpsearchbar__form">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search Product...">
                                <button class="tpsearchbar__search-btn"><i class="icon-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-body-overlay"></div>
    <!-- header-search-end -->

    <!-- header-cart-start -->
    <div class="tpcartinfo tp-cart-info-area p-relative">
        <button class="tpcart__close"><i class="icon-x"></i></button>
        <div class="tpcart">
            <h4 class="tpcart__title">Your Cart</h4>
            <div class="tpcart__product">
                <div class="tpcart__product-list">
                    <ul>
                        <li>
                            <div class="tpcart__item">
                                <div class="tpcart__img">
                                    <img src="{{ asset('orfarm/assets/img/product/products1-min.jpg') }}" alt="">
                                    <div class="tpcart__del">
                                        <a href="#"><i class="icon-x-circle"></i></a>
                                    </div>
                                </div>
                                <div class="tpcart__content">
                                    <span class="tpcart__content-title"><a href="shop-details.html">Stacy's Pita Chips Parmesan Garlic & Herb From Nature</a>
                                    </span>
                                    <div class="tpcart__cart-price">
                                        <span class="quantity">1 x</span>
                                        <span class="new-price">$162.80</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="tpcart__item">
                                <div class="tpcart__img">
                                    <img src="{{ asset('orfarm/assets/img/product/products12-min.jpg') }}" alt="">
                                    <div class="tpcart__del">
                                        <a href="#"><i class="icon-x-circle"></i></a>
                                    </div>
                                </div>
                                <div class="tpcart__content">
                                    <span class="tpcart__content-title"><a href="shop-details.html">Banana, Beautiful Skin, Good For Health 1Kg</a>
                                    </span>
                                    <div class="tpcart__cart-price">
                                        <span class="quantity">1 x</span>
                                        <span class="new-price">$138.00</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="tpcart__item">
                                <div class="tpcart__img">
                                    <img src="{{ asset('orfarm/assets/img/product/products3-min.jpg') }}" alt="">
                                    <div class="tpcart__del">
                                        <a href="#"><i class="icon-x-circle"></i></a>
                                    </div>
                                </div>
                                <div class="tpcart__content">
                                    <span class="tpcart__content-title"><a href="shop-details.html">Quaker Popped Rice Crisps Snacks Chocolate</a>
                                    </span>
                                    <div class="tpcart__cart-price">
                                        <span class="quantity">1 x</span>
                                        <span class="new-price">$162.8</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tpcart__checkout">
                    <div class="tpcart__total-price d-flex justify-content-between align-items-center">
                        <span> Subtotal:</span>
                        <span class="heilight-price"> $300.00</span>
                    </div>
                    <div class="tpcart__checkout-btn">
                        <a class="tpcart-btn mb-10" href="cart.html">View Cart</a>
                        <a class="tpcheck-btn" href="checkout.html">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="tpcart__free-shipping text-center">
                <span>Free shipping for orders <b>under 10km</b></span>
            </div>
        </div>
    </div>
    <div class="cartbody-overlay"></div>
    <!-- header-cart-end -->

    <!-- mobile-menu-area -->
    <div id="header-sticky-2" class="tpmobile-menu d-xl-none">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 col-3 col-sm-3">
                    <div class="mobile-menu-icon">
                        <button class="tp-menu-toggle"><i class="icon-menu1"></i></button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-6 col-sm-4">
                    <div class="header__logo text-center">
                        <a href="index.html"><img src="{{ asset('orfarm/assets/img/logo/logo.png') }}" alt=" logo"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-3 col-sm-5">
                    <div class="header__info d-flex align-items-center">
                        <div class="header__info-search tpcolor__purple ml-10 d-none d-sm-block">
                            <button class="tp-search-toggle"><i class="icon-search"></i></button>
                        </div>
                        <div class="header__info-user tpcolor__yellow ml-10 d-none d-sm-block">
                            <a href="log-in.html"><i class="icon-user"></i></a>
                        </div>
                        <div class="header__info-wishlist tpcolor__greenish ml-10 d-none d-sm-block">
                            <a href="wishlist.html"><i class="icon-heart icons"></i></a>
                        </div>
                        <div class="header__info-cart tpcolor__oasis ml-10 tp-cart-toggle">
                            <button><i><img src="{{ asset('orfarm/assets/img/icon/cart-1.svg') }}" alt=""></i>
                                <span>5</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-overlay"></div>
    <!-- mobile-menu-area-end -->

    <!-- sidebar-menu-area -->
    <div class="tpsideinfo">
        <button class="tpsideinfo__close">Close<i class="fal fa-times ml-10"></i></button>
        <div class="tpsideinfo__search text-center pt-35">
            <span class="tpsideinfo__search-title mb-20">What Are You Looking For?</span>
            <form action="#">
                <input type="text" placeholder="Search Products...">
                <button><i class="icon-search"></i></button>
            </form>
        </div>
        <div class="tpsideinfo__nabtab">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Menu</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Categories</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="mobile-menu"></div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="tpsidebar-categories">
                        <ul>
                            <li><a href="shop-details.html">Dairy Farm</a></li>
                            <li><a href="shop-details.html">Healthy Foods</a></li>
                            <li><a href="shop-details.html">Lifestyle</a></li>
                            <li><a href="shop-details.html">Organics</a></li>
                            <li><a href="shop-details.html">Photography</a></li>
                            <li><a href="shop-details.html">Shopping</a></li>
                            <li><a href="shop-details.html">Tips & Tricks</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tpsideinfo__account-link">
            <a href="log-in.html"><i class="icon-user icons"></i> Login / Register</a>
        </div>
        <div class="tpsideinfo__wishlist-link">
            <a href="wishlist.html" target="_parent"><i class="icon-heart"></i> Wishlist</a>
        </div>
    </div>
    <!-- sidebar-menu-area-end -->
</header>
<!-- header-area-end -->
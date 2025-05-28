<x-app :kategoris="$kategoris">
    <!-- slider-area-start -->
    <section class="slider-area tpslider-delay">
        <div class="swiper-container slider-active">
            <div class="swiper-wrapper">
                @foreach ($hero as $hero)
                    <div class="swiper-slide ">
                        <div class="tpslider pb-90 mb-96 grey-bg" data-background="orfarm/assets/img/slider/shape-bg.jpg"
                            style="background-size: cover; background-repeat: no-repeat;">
                            <div class="container h-100">
                                <div class="row align-items-center">
                                    <div class="col-xxl-5 col-lg-6 col-md-6 col-12 col-sm-6">
                                        <div class="tpslider__content pt-20">
                                            <span class="tpslider__sub-title mb-35">{{$hero->subheader}}</span>
                                            <h2 class="tpslider__title mb-30">{{ $hero->header }}.</h2>
                                            <p>{!! $hero->paragraph !!}</p>
                                            <div class="tpslider__btn">
                                                <a class="tp-btn" href="{{ $hero->cta }}">{{$hero->cta_text}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7 col-lg-6 col-md-6 col-12 col-sm-6 text-center">
                                        <div class="tpslider__thumb p-relative pt-15">
                                            <img class="tpslider__thumb-img"
                                                src="{{ $hero->getFirstMediaUrl('foto_hero') }}" alt="slider-bg"
                                                style="max-height: 50vh !important; width: auto !important;">
                                            <div class="tpslider__shape d-none d-md-block">
                                                <img class="tpslider__shape-one"
                                                    src="orfarm/assets/img/slider/slider-shape-1.png" alt="shape">
                                                <img class="tpslider__shape-two"
                                                    src="orfarm/assets/img/slider/slider-shape-2.png" alt="shape">
                                                <img class="tpslider__shape-three"
                                                    src="orfarm/assets/img/slider/slider-shape-3.png" alt="shape">
                                                <img class="tpslider__shape-four"
                                                    src="orfarm/assets/img/slider/slider-shape-4.png" alt="shape">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tpslider__arrow d-none  d-xxl-block">
                <button class="tpsliderarrow tpslider__arrow-prv"><i class="icon-chevron-left"></i></button>
                <button class="tpsliderarrow tpslider__arrow-nxt"><i class="icon-chevron-right"></i></button>
            </div>
            <div class="slider-pagination d-xxl-none"></div>
        </div>
    </section>
    <!-- slider-area-end -->

    <!-- category-area-start -->
    <section class="category-area grey-bg pb-40">
        <div class="container d-flex">
            <div class="swiper-container category-active w-100">
                <div class="swiper-wrapper d-flex justify-content-start justify-content-xl-center">
                    @foreach ($kategori as $kategori)
                        <div class="swiper-slide">
                            <div class="category__item mb-30">
                                <div class="category__thumb fix mb-15">
                                    <a href="{{ route('toko.kategori', ['kategoriSlug' => $kategori->slug]) }}">
                                        <img src="{{ $kategori->getFirstMediaUrl('foto_kategori')}}"
                                            alt="{{ $kategori->nama_kategori }}">
                                    </a>
                                </div>
                                <div class="category__content">
                                    <h5 class="category__title"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <a
                                            href="{{ route('toko.kategori', ['kategoriSlug' => $kategori->slug]) }}">{{ ucfirst($kategori->nama_kategori) }}</a>
                                    </h5>
                                    <span class="category__count">{{ $kategori->Product->count() }} items</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- category-area-end -->

    <!-- product-area-start -->
    <section class="product-area grey-bg pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="tpsection mb-35">
                        <h4 class="tpsection__sub-title">~ Produk Spesial ~</h4>
                        <h4 class="tpsection__title">Penawaran Produk Mingguan</h4>
                        <p>Nikmati diskon eksklusif setiap minggu untuk produk pilihan! Hemat lebih banyak dan temukan
                            barang favorit Anda dengan harga terbaik.</p>
                    </div>
                </div>
            </div>
            <div class="tpproduct__arrow p-relative">
                <div class="swiper-container tpproduct-active tpslider-bottom p-relative">
                    <div class="swiper-wrapper">
                        @foreach ($product as $index => $productItem)
                            <div class="swiper-slide">
                                <div class="tpproduct p-relative">
                                    <div class="tpproduct__thumb p-relative text-center">
                                        <a href="/produk/{{ $productItem->slug }}">
                                            <img src="{{ $productItem->getMedia('foto_product')->first()?->getUrl() }}"
                                                alt="{{$productItem->nama_product}}"
                                                style="aspect-ratio: 1/1 !important; overflow: hidden; object-fit: cover;">
                                        </a>
                                        <a class="tpproduct__thumb-img" href="/produk/{{ $productItem->slug }}">
                                            <img src="{{ $productItem->getMedia('foto_product')->get(1)?->getUrl() }}"
                                                alt="{{$productItem->nama_product}}"
                                                style="aspect-ratio: 1/1 !important; overflow: hidden; object-fit: cover;">
                                        </a>
                                        <div class="tpproduct__info bage">
                                            <span
                                                class="tpproduct__info-discount bage__discount">{{$productItem->diskon}}%</span>
                                            <span
                                                class="tpproduct__info-hot bage__hot">{{ $productItem->label == 1 ? 'SUPER MURAH🔥' : '' }}</span>
                                        </div>
                                        <div class="tpproduct__shopping">
                                            <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i
                                                    class="icon-heart icons"></i></a>
                                            <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                            <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="tpproduct__content">
                                        <span class="tpproduct__content-weight">
                                            <a
                                                href="/produk/{{ $productItem->slug }}">{{ ucfirst($productItem->kategori->nama_kategori) }}</a>
                                        </span>
                                        <h4 class="tpproduct__title">
                                            <a
                                                href="/produk/{{ $productItem->slug }}">{{ ucfirst($productItem->nama_product) }}</a>
                                        </h4>
                                        <div class="tpproduct__rating mb-5">
                                            <a href="#"><i class="icon-star_outline1"></i></a>
                                            <a href="#"><i class="icon-star_outline1"></i></a>
                                            <a href="#"><i class="icon-star_outline1"></i></a>
                                            <a href="#"><i class="icon-star_outline1"></i></a>
                                            <a href="#"><i class="icon-star_outline1"></i></a>
                                        </div>
                                        <div class="tpproduct__price">
                                            <span>Rp{{ number_format($productItem->harga, 0, ',', '.') }}</span><br>
                                            <del>Rp{{ number_format($productItem->harga + ($productItem->harga * $productItem->diskon / 100), 0, ',', '.') }}</del>
                                        </div>
                                    </div>
                                    <div class="tpproduct__hover-text">
                                        <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                            <a href="/produk/{{ $productItem->slug }}"
                                                class="tp-btn-2 d-flex justify-content-center mb-10">
                                                Lihat Produk
                                            </a>
                                        </div>
                                        <div class="tpproduct__descrip">
                                            <ul>
                                                <li>Terjual {{ $productItem->terjual }}+ </li>
                                                <li>{{ $productItem->created_at->since() }}</li>
                                                <li>Jaminan Privasi Aman</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tpproduct-btn">
                    <div class="tpprduct-arrow tpproduct-btn__prv"><a href="#"><i class="icon-chevron-left"></i></a>
                    </div>
                    <div class="tpprduct-arrow tpproduct-btn__nxt"><a href="#"><i class="icon-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-area-end -->

    <!-- product-feature-area-start -->
    <section class="product-feature-area product-feature grey-bg pt-80 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="tpfeature__thumb p-relative pb-40">
                        <img src="{{ $SingleProduct->getMedia('foto_product')->first()?->getUrl() }}" alt=""
                            style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="tpfeature__shape d-none d-md-block">
                            <img class="tpfeature__shape-one" src="orfarm/assets/img/product/feature-shape-1.png"
                                alt="">
                            <img class="tpfeature__shape-two" src="orfarm/assets/img/product/feature-shape-2.png"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="tpproduct-feature p-relative pt-45 pb-40">
                        <div class="tpsection tpfeature__content mb-35">
                            <h4 class="tpsection__sub-title mb-0">~ Pilihan Terbaik Untuk Kamu ~</h4>
                            <h4 class="tpsection__title tpfeature__title mb-25">{{ $SingleProduct->nama_product }} <br>
                                <span>{{ $SingleProduct->brand }}</span> - Gamora Indonesia
                            </h4>
                            <p>{!! substr($SingleProduct->ringkasan, 0, 100) !!}{!! strlen($productItem->ringkasan) > 100 ? '...' : '' !!}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="tpfeature__box">
                                    <div class="tpfeature__product-item mb-25">
                                        <h4 class="tpfeature__product-title">Brand:</h4>
                                        <span class="tpfeature__product-info">{{ $SingleProduct->brand }}</span>
                                    </div>
                                    <div class="tpfeature__product-item mb-45">
                                        <h4 class="tpfeature__product-title">Kategori:</h4>
                                        <span
                                            class="tpfeature__product-">{{ $SingleProduct->kategori->nama_kategori }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 text-truncate">
                                <div class="tpfeature__box">
                                    <div class="tpfeature__product-item mb-25">
                                        <h4 class="tpfeature__product-title">Ingredient:</h4>
                                        <span
                                            class="tpfeature__product-info text-truncate ">{!! $SingleProduct->ingredient !!}</span>
                                    </div>
                                    <div class="tpfeature__product-item mb-45">
                                        <h4 class="tpfeature__product-title">Ukuran:</h4>
                                        <span class="tpfeature__product-">{{ $SingleProduct->size }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="tpfeature__btn" bis_skin_checked="1">
                                    <a class="tp-btn-4" href="/produk/{{ $SingleProduct->slug }}">Lihat Produk</a>
                                </div>
                                <div class="tpfeature__btn">
                                    <a class="tp-btn-3" href="/produk/{{ $SingleProduct->slug }}">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="tpfeature__shape d-none d-md-block">
                            <img class="tpfeature__shape-three" src="orfarm/assets/img/product/feature-shape-3.png"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-feature-area-end -->

    <!-- banner-area-start -->
    <section class="banner-area pb-60 grey-bg">
        <div class="container">
            <div class="row">
                @foreach ($promo as $promo)
                    <div class="col-lg-4 col-md-6">
                        <div class="tpbanner__item mb-30">
                            <a href="shop-3.html">
                                <div class="tpbanner__content"
                                    data-background="{{ $promo->getMedia('banner_promo')->first()?->getUrl() }}">
                                    <span class="tpbanner__sub-title mb-10">{{ ucfirst($promo->judul) }}</span>
                                    @php
                                        $text_promo = ucfirst(Str::limit(strip_tags($promo->text_promo), 35))
                                    @endphp
                                    <h4 class="tpbanner__title mb-30">{{ $text_promo }}</h4>
                                    <p>Lihat <strong>{{$promo->judul}}</strong> nyaaa</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- banner-area-end -->

    <!-- product-area-start -->
    <section class="weekly-product-area grey-bg pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="tpsection mb-20">
                        <h4 class="tpsection__sub-title">~ Produk Spesial ~</h4>
                        <h4 class="tpsection__title">Penawaran Produk Mingguan</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tpnavtab__area pb-40">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                                    aria-selected="true">Semua</button>
                                @foreach ($kategoris as $kat)
                                    <button class="nav-link" id="nav-{{$kat->slug}}-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-{{$kat->slug}}" type="button" role="tab"
                                        aria-controls="nav-{{$kat->slug}}"
                                        aria-selected="false">{{ ucfirst($kat->nama_kategori) }}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <x-produk :produk="$product"></x-produk>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tpproduct__all-item text-center">
                        <span>Temukan puluhan produk berkualitas lainya.
                            <a href="shop-3.html">Belanja semua produk <i class="icon-chevrons-right"></i></a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-area-end -->

    <!-- product-coundown-area-start -->
    <!-- <section class="product-coundown-area tpcoundown__bg grey-bg pb-25" data-background="orfarm/assets/img/banner/coundpwn-bg-1.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tpcoundown p-relative ml-175">
                        <div class="section__content mb-35">
                            <span class="section__sub-title mb-10">~ Deals Of The Day ~</span>
                            <h2 class="section__title mb-25">Premium Drinks <br> Fresh Farm Product</h2>
                            <p>The liber tempor cum soluta nobis eleifend option congue <br>
                                doming quod mazim placerat facere possum assam going through.</p>
                        </div>
                        <div class="tpcoundown__count">
                            <h4 class="tpcoundown__count-title">hurry up! Offer End In:</h4>
                            <div class="tpcoundown__countdown" data-countdown="2022/11/11"></div>
                            <div class="tpcoundown__btn mt-50">
                                <a class="whight-btn" href="shop-details-grid.html">Shop Now</a>
                                <a class="whight-btn border-btn ml-15" href="shop-list-view.html">View Menu</a>
                            </div>
                        </div>
                        <div class="tpcoundown__shape d-none d-lg-block">
                            <img class="tpcoundown__shape-one" src="orfarm/assets/img/shape/tree-leaf-1.svg" alt="">
                            <img class="tpcoundown__shape-two" src="orfarm/assets/img/shape/tree-leaf-2.svg" alt="">
                            <img class="tpcoundown__shape-three" src="orfarm/assets/img/shape/tree-leaf-3.svg" alt="">
                            <img class="tpcoundown__shape-four" src="orfarm/assets/img/shape/fresh-shape-1.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- product-coundown-area-end -->

    <!-- blog-area-start -->
    <section class="blog-area pt-100 pb-100 grey-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="tpsection mb-35">
                        <h4 class="tpsection__sub-title">~ Read Our Blog ~</h4>
                        <h4 class="tpsection__title">Our Latest Post</h4>
                        <p>The liber tempor cum soluta nobis eleifend option congue doming quod mazim.</p>
                    </div>
                </div>
            </div>
            <div class="swiper-container tpblog-active">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-1.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Lifestyle</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Avocado Grilled Salmon, Rich In
                                        Nutrients For The Body</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-2.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Organics</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">The Best Great Benefits Of
                                        Fresh Beef For Women's Health</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-3.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Organics</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Ways To Choose Fruits &
                                        Seafoods Good For Pregnancy</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-4.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Shopping</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Summer Breakfast For The Healthy
                                        Morning With Tomatoes</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-5.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="#">Foods</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Popular Reasons You Must Drinks
                                        Juice Everyday</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-6.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Lifestyle</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Perfect Quality Reasonable Price
                                        For Your Family</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-7.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="shop-details.html">Dairy Farm</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">Ways To Choose Fruits Seafoods
                                        Good For Pregnancy</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tpblog__item">
                            <div class="tpblog__thumb fix">
                                <a href="blog-details.html"><img src="orfarm/assets/img/blog/blog-bg-8.jpg" alt=""></a>
                            </div>
                            <div class="tpblog__wrapper">
                                <div class="tpblog__entry-wap">
                                    <span class="cat-links"><a href="#">organis</a></span>
                                    <span class="author-by"><a href="#">Admin</a></span>
                                    <span class="post-data"><a href="#">SEP 15. 2022</a></span>
                                </div>
                                <h4 class="tpblog__title"><a href="blog-details.html">The Best Great Benefits Of Fresh
                                        Beef For Women’s Health</a></h4>
                                <p>These are the people who make your life easier. Egestas is tristique vestibulum...
                                </p>
                                <div class="tpblog__details">
                                    <a href="blog-details.html">Continue reading <i class="icon-chevrons-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->
</x-app>
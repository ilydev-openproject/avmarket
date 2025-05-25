<x-app>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area grey-bg pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><a href="/">Home</a></span>
                            <span class="dvdr">/</span>
                            <span class="tp-breadcrumb__active"><a href="/toko">Toko</a></span>
                            <span class="dvdr">/</span>
                            <span>{{ $product->nama_product }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- shop-details-area-start -->
    <section class="shopdetails-area grey-bg pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <div class="tpdetails__area mr-60 pb-30">
                        <div class="tpdetails__product mb-30">
                            <div class="tpdetails__title-box">
                                <h3 class="tpdetails__title">{{ $product->nama_product }}</h3>
                                <ul class="tpdetails__brand">
                                    <li> Brands: <a href="#">{{ $product->brand }}</a> </li>
                                    <li>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <b></b>
                                    </li>
                                    <li>
                                        BPOM: <span>{{ $product->bpom }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="tpdetails__box">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="tpproduct-details__nab">
                                            <div class="tab-content" id="nav-tabContents">
                                                @foreach($product->getMedia('foto_product') as $index => $media)
                                                    <div class="tab-pane fade p-5 {{ $loop->first ? 'show active' : '' }} w-img"
                                                        id="nav-{{ $index }}" role="tabpanel"
                                                        aria-labelledby="nav-tab-{{ $index }}" tabindex="0">
                                                        <img src="{{ $media->getUrl() }}" alt="{{$media->nama_product}}"
                                                            style="aspect-ratio: 1/1; object-fit: cover; object-position: center;">
                                                        <div class="tpproduct__info bage">
                                                            <span
                                                                class="tpproduct__info-hot bage__hot">{{ $product->label == 1 ? 'SUPER MURAH🔥' : 'MURAH' }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <nav>
                                                <div class="nav nav-tabs justify-content-center py-3" id="nav-tab"
                                                    role="tablist">
                                                    @foreach($product->getMedia('foto_product') as $index => $media)
                                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                            id="nav-tab-{{ $index }}" data-bs-toggle="tab"
                                                            data-bs-target="#nav-{{ $index }}" type="button" role="tab"
                                                            aria-controls="nav-{{ $index }}"
                                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                            <img src="{{ $media->getUrl() }}" alt="{{$media->nama_product}}"
                                                                style="aspect-ratio: 1/1; object-fit: cover; object-position: center;">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </nav>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="product__details">
                                            <div class="product__details-price-box">
                                                <del>Rp{{ number_format($product->harga + ($product->harga * $product->diskon / 100), 0, ',', '.') }}</del>
                                                <h5 class="product__details-price">
                                                    Rp{{ number_format($product->harga, 0, ',', '.') }}</h5>
                                                <div class="ms-4">
                                                    <span>{!! $product->manfaat !!}</span>
                                                </div>
                                            </div>
                                            <div class="product__details-cart">
                                                <div class="product__details-quantity d-flex align-items-center mb-15">
                                                    <b>Qty:</b>
                                                    <div class="product__details-count mr-10">
                                                        <span class="cart-minus"><i class="far fa-minus"></i></span>
                                                        <input class="tp-cart-input" type="text" value="1">
                                                        <span class="cart-plus"><i class="far fa-plus"></i></span>
                                                    </div>
                                                    <div class="product__details-btn">
                                                        <a href="cart.html">Keranjang</a>
                                                    </div>
                                                </div>
                                                <ul class="product__details-check">
                                                    <li>
                                                        <span><i class="icon-key"></i> Jaminan Privasi Aman</span>
                                                    </li>
                                                    <li>
                                                        <livewire:add-to-favorite :productId="$product->id" />
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon-share-2"></i> Share</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="product__details-stock mb-25">
                                                <ul>
                                                    <li>Terjual: <i>{{ $product->terjual }}+</i></li>
                                                    <li>Kategori: <span>{{ $product->kategori->nama_kategori }}</span>
                                                    </li>
                                                    <li>Tags:
                                                        @foreach ($product->tags as $tag)
                                                            <a href="#"
                                                                class="tag-link"><span>{{ $tag->nama_tag }}</span></a>{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="product__details-payment text-center">
                                                <img src="{{ asset('orfarm/assets/img/shape/payment-2.png') }}" alt="">
                                                <span>Garansi Pemesanan Aman</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tpdescription__box">
                            <div class="tpdescription__box-center d-flex align-items-center justify-content-center">
                                <nav>
                                    <div class="nav nav-tabs" role="tablist">
                                        <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-description" type="button" role="tab"
                                            aria-controls="nav-description" aria-selected="true">Deskripsi</button>
                                        <!-- <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Ulasan (1)</button> -->
                                    </div>
                                </nav>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                    aria-labelledby="nav-description-tab" tabindex="0">
                                    <div class="tpdescription__content">
                                        <p>{!! $product->deskripsi !!}</p>
                                    </div>
                                    <div
                                        class="tpdescription__product-wrapper mt-30 mb-30 d-flex justify-content-between align-items-center">
                                        <div class="tpdescription__product-info">
                                            <h5 class="tpdescription__product-title">DETAIL PRODUK</h5>
                                            <ul class="tpdescription__product-info">
                                                <li>Brand: {{ $product->brand }}</li>
                                                <li>Nama Produk: {{ $product->nama_product }}</li>
                                                <li>Size/Ukuran: {{ $product->size }}</li>
                                                <li>NO. BPOM: {{ $product->bpom }}</li>
                                                <li>Kategori: {{ $product->kategori->nama_kategori }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tpdescription__video pb-4">
                                        <h5 class="tpdescription__product-title">Manfaat Produk</h5>
                                        <p>Berikut beberapa manfaat dari produk {{ $product->nama_product}} untuk
                                            kebutuhan harian ataupun solusi dari permasalahan anda terkait dengan
                                            kesehatan herbal {{ $product->kategori->nama_kategori }} :</p>
                                        <ul class="ps-4">
                                            {!! $product->manfaat !!}
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-information" role="tabpanel"
                                    aria-labelledby="nav-info-tab" tabindex="0">
                                    <div class="tpdescription__content">
                                        <p>Designed by Puik in 1949 as one of the first models created especially for
                                            Carl Hansen & Son, and produced since 1950. The last of a series of chairs
                                            wegner designed based on inspiration from antique chinese armchairs.
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                            eserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste
                                            natus error sit voluptatem accusantium doloremque laudantium, totam rem
                                            aperiam, aque ipsa quae ab illo inventore veritatis et quasi architecto
                                            beatae vitae dicta sunt explicabo. </p>
                                    </div>
                                    <div
                                        class="tpdescription__product-wrapper mt-30 mb-30 d-flex justify-content-between align-items-center">
                                        <div class="tpdescription__product-info">
                                            <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                            <ul class="tpdescription__product-info">
                                                <li>Material: Plastic, Wood</li>
                                                <li>Legs: Lacquered oak and black painted oak</li>
                                                <li>Dimensions and Weight: Height: 80 cm, Weight: 5.3 kg</li>
                                                <li>Length: 48cm</li>
                                                <li>Depth: 52 cm</li>
                                            </ul>
                                            <p>Lemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut <br>
                                                fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem
                                                <br> sequi nesciunt.</p>
                                        </div>
                                        <div class="tpdescription__product-thumb">
                                            <img src="assets/img/product/product-single-1.png" alt="">
                                        </div>
                                    </div>
                                    <div class="tpdescription__video">
                                        <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                        <p>Form is an armless modern chair with a minimalistic expression. With a simple
                                            and contemporary design Form Chair has a soft and welcoming ilhouette and a
                                            distinctly residential look. The legs appear almost as if they are growing
                                            out of the shell. This gives the design flexibility and makes it possible to
                                            vary the frame. Unika is a mouth blown series of small, glass pendant lamps,
                                            originally designed for the Restaurant Gronbech. Est eum itaque maiores qui
                                            blanditiis architecto. Eligendi saepe rem ut. Cumque quia earum eligendi.
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-review" role="tabpanel"
                                    aria-labelledby="nav-review-tab" tabindex="0">
                                    <div class="tpreview__wrapper">
                                        <h4 class="tpreview__wrapper-title">1 review for Cheap and delicious fresh
                                            chicken</h4>
                                        <div class="tpreview__comment">
                                            <div class="tpreview__comment-img mr-20">
                                                <img src="assets/img/testimonial/test-avata-1.png" alt="">
                                            </div>
                                            <div class="tpreview__comment-text">
                                                <div
                                                    class="tpreview__comment-autor-info d-flex align-items-center justify-content-between">
                                                    <div class="tpreview__comment-author">
                                                        <span>admin</span>
                                                    </div>
                                                    <div class="tpreview__comment-star">
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                    </div>
                                                </div>
                                                <span class="date mb-20">--April 9, 2022: </span>
                                                <p>very good</p>
                                            </div>
                                        </div>
                                        <div class="tpreview__form">
                                            <h4 class="tpreview__form-title mb-25">Add a review </h4>
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="tpreview__input mb-30">
                                                            <input type="text" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="tpreview__input mb-30">
                                                            <input type="email" placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="tpreview__star mb-20">
                                                            <h4 class="title">Your Rating</h4>
                                                            <div class="tpreview__star-icon">
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="tpreview__input mb-30">
                                                            <textarea name="text" placeholder="Message"></textarea>
                                                            <div class="tpreview__submit mt-30">
                                                                <button class="tp-btn">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12">
                    <div class="tpsidebar pb-30">
                        <div class="tpsidebar__warning mb-30">
                            <ul>
                                <li>
                                    <div class="tpsidebar__warning-item">
                                        <div class="tpsidebar__warning-icon">
                                            <i class="icon-package"></i>
                                        </div>
                                        <div class="tpsidebar__warning-text">
                                            <p>Gratis ongkir untuk pulau jawa atau belanja lebih dari 150ribu.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tpsidebar__warning-item">
                                        <div class="tpsidebar__warning-icon">
                                            <i class="icon-shield"></i>
                                        </div>
                                        <div class="tpsidebar__warning-text">
                                            <p>Garansi produk 100% ori dari pabrik langsung.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tpsidebar__warning-item">
                                        <div class="tpsidebar__warning-icon">
                                            <i class="icon-package"></i>
                                        </div>
                                        <div class="tpsidebar__warning-text">
                                            <p>60 Hari retur produk jika pesanan tidak sesuai.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tpsidebar__banner mb-30">
                            <img src="{{ asset('orfarm/assets/img/shape/sidebar-product-1.png') }}" alt="">
                        </div>
                        <x-toko.recent-product :recentProduct="$recentProduct"></x-toko.recent-product>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-details-area-end -->

    <x-toko.related-product :relatedProducts="$relatedProducts" />

</x-app>
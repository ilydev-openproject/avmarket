<!-- product-area-start -->
<section class="product-area whight-product pt-75 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="tpdescription__product-title mb-20">Related Products</h5>
            </div>
        </div>
        <div class="tpproduct__arrow double-product p-relative">
            <div class="swiper-container tpproduct-active-custom tpslider-bottom p-relative">
                <div class="swiper-wrapper">
                    @props(['relatedProducts'])
                    @foreach ($relatedProducts as $related)
                    <div class="swiper-slide">
                        <div class="tpproduct p-relative">
                            <div class="tpproduct__thumb p-relative text-center">
                                <a href="/toko/{{ $related->slug }}"><img src="{{ $related->getMedia('foto_product')->first()?->getUrl() }}" alt="" style="aspect-ratio: 1/1; object-fit: cover; width: 100%;"></a>
                                <a class="tpproduct__thumb-img" href="/toko/{{ $related->slug }}"><img src="{{ $related->getMedia('foto_product')->get(1)?->getUrl() }}" alt="" style="aspect-ratio: 1/1; object-fit: cover; width: 100%;"></a>
                                <div class="tpproduct__info bage">
                                    <span class="tpproduct__info-discount bage__discount">-50%</span>
                                    <span class="tpproduct__info-hot bage__hot">HOT</span>
                                </div>
                                <div class="tpproduct__shopping">
                                    <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                    <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                    <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                </div>
                            </div>
                            <div class="tpproduct__content">
                                <span class="tpproduct__content-weight">
                                    <a href="">{{ $related->kategori->nama_kategori }}</a>
                                </span>
                                <h4 class="tpproduct__title">
                                    <a href="/toko/{{ $related->slug }}">{{ $related->nama_product}}</a>
                                </h4>
                                <div class="tpproduct__rating mb-5">
                                    <a href="#"><i class="icon-star_outline1"></i></a>
                                    <a href="#"><i class="icon-star_outline1"></i></a>
                                    <a href="#"><i class="icon-star_outline1"></i></a>
                                    <a href="#"><i class="icon-star_outline1"></i></a>
                                    <a href="#"><i class="icon-star_outline1"></i></a>
                                </div>
                                <div class="tpproduct__price">
                                    <span>Rp{{ number_format($related->harga, 0, ',', '.') }}</span>
                                    <del>Rp{{ number_format($related->harga + ($related->harga * $related->diskon / 100), 0, ',', '.') }}</del>
                                </div>
                            </div>
                            <div class="tpproduct__hover-text">
                                <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                    <a class="tp-btn-2" href="cart.html">Add to cart</a>
                                </div>
                                <div class="tpproduct__descrip">
                                    <ul>
                                        <li>Type: Organic</li>
                                        <li>MFG: August 4.2021</li>
                                        <li>LIFE: 60 days</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product-area-end -->
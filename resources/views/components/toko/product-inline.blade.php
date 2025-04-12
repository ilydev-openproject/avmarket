<div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 tpproduct__shop-item">
    @foreach ($products as $products)
    <div class="col">
        <div class="tpproduct p-relative mb-20">
            <div class="tpproduct__thumb p-relative text-center">
                <a href="#"><img src="{{ $products->getMedia('foto_product')->first()?->getUrl() }}" alt=""></a>
                <a class="tpproduct__thumb-img" href="shop-details-grid.html"><img src="assets/img/product/products1-min.jpg" alt=""></a>
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
                    <a href="shop-details-3.html">Fresh Fruits</a>,
                    <a href="shop-details-3.html">Vagetables</a>
                </span>
                <h4 class="tpproduct__title">
                    <a href="shop-details-top-.html">Mangosteen Organic From VietNamese</a>
                </h4>
                <div class="tpproduct__rating mb-5">
                    <a href="#"><i class="icon-star_outline1"></i></a>
                    <a href="#"><i class="icon-star_outline1"></i></a>
                    <a href="#"><i class="icon-star_outline1"></i></a>
                    <a href="#"><i class="icon-star_outline1"></i></a>
                    <a href="#"><i class="icon-star_outline1"></i></a>
                </div>
                <div class="tpproduct__price">
                    <span>Rp{{ number_format($products->harga, 0, ',', '.') }}</span><br>
                    <del>Rp{{ number_format($products->harga + ($products->harga * $products->diskon / 100), 0, ',', '.') }}</del>
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
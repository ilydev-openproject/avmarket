@php
use App\Models\Kategori;
use App\Models\Product;

$kategori = Kategori::with('product')->get();
@endphp
@foreach ($kategori as $kat)
<div class="tab-pane fade" id="nav-{{ $kat->slug }}" role="tabpanel" aria-labelledby="nav-{{ $kat->slug }}-tab" tabindex="0">
    <div class="tpproduct__arrow p-relative">
        <div class="swiper-container tpproduct-active-custom" data-loop="{{ $kat->Product->count() >= 3 ? 'true' : 'false' }}">
            <div class="swiper-wrapper">
                @forelse ($kat->product as $produk)
                <div class="swiper-slide">
                    <div class="tpproduct p-relative">
                        <div class="tpproduct__thumb p-relative text-center">
                            <a href="#"><img src="{{ $produk->getMedia('foto_product')->first()?->getUrl() }}" alt=""></a>
                            <a class="tpproduct__thumb-img" href="shop-details.html"><img src="{{ $produk->getMedia('foto_product')->get(1)?->getUrl() }}" alt=""></a>
                            <div class="tpproduct__info bage">
                                <span class="tpproduct__info-discount bage__discount">{{$produk->diskon}}%</span>
                                <span class="tpproduct__info-hot bage__hot">{{ $produk->label == 1 ? 'SUPER MURAH🔥' : '' }}</span>
                            </div>
                            <div class="tpproduct__shopping">
                                <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                            </div>
                        </div>
                        <div class="tpproduct__content">
                            <span class="tpproduct__content-weight">
                                <a href="shop-details-4.html">{{ ucfirst($produk->kategori->nama_kategori) }}</a>
                            </span>
                            <h4 class="tpproduct__title">
                                <a href="shop-details-4.html">{{ ucfirst($produk->nama_product) }}</a>
                            </h4>
                            <div class="tpproduct__rating mb-5">
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                            </div>
                            <div class="tpproduct__price">
                                <span>Rp{{ number_format($produk->harga, 0, ',', '.') }}</span><br>
                                <del>Rp{{ number_format($produk->harga + ($produk->harga * $produk->diskon / 100), 0, ',', '.') }}</del>
                            </div>
                        </div>
                        <div class="tpproduct__hover-text">
                            <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                            </div>
                            <div class="tpproduct__descrip">
                                <ul>
                                    <li>Terjual 2000+ </li>
                                    <li>{{ $produk->created_at->since() }}</li>
                                    <li>LIFE: 60 days</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="swiper-slide text-center w-100">
                    <div class="p-5">
                        <p class="text-muted">Belum ada produk di kategori ini.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="tpproduct-btn">
            <div class="tpprduct-arrow tpproduct-btn__prv"><a href="#"><i class="icon-chevron-left"></i></a></div>
            <div class="tpprduct-arrow tpproduct-btn__nxt"><a href="#"><i class="icon-chevron-right"></i></a></div>
        </div>
    </div>
</div>
@endforeach
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab" tabindex="0">
        <div class="tpproduct__arrow p-relative">
            <div class="swiper-container tpproduct-active tpslider-bottom p-relative">
                <div class="swiper-wrapper">
                    @foreach ($produk as $prod)
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="/produk/{{ $prod->slug}}"><img
                                            src="{{ $prod->getMedia('foto_product')->first()?->getUrl() }}" alt=""
                                            style="aspect-ratio: 1/1 !important; overflow: hidden; object-fit: cover;"></a>
                                    <a class="tpproduct__thumb-img" href="/produk/{{ $prod->slug}}"><img
                                            src="{{ $prod->getMedia('foto_product')->get(1)?->getUrl() }}" alt=""
                                            style="aspect-ratio: 1/1 !important; overflow: hidden; object-fit: cover;"></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">{{$prod->diskon}}%</span>
                                        <span
                                            class="tpproduct__info-hot bage__hot">{{ $prod->label == 1 ? 'SUPER MURAH🔥' : '' }}</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-cart" href="/produk/{{ $prod->slug}}"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                    <span class="tpproduct__content-weight">
                                        <a href="shop-details-4.html">{{ ucfirst($prod->kategori->nama_kategori) }}</a>
                                    </span>
                                    <h4 class="tpproduct__title">
                                        <a href="/produk/{{ $prod->slug}}">{{ ucfirst($prod->nama_product) }}</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rp{{ number_format($prod->harga, 0, ',', '.') }}</span><br>
                                        <del>Rp{{ number_format($prod->harga + ($prod->harga * $prod->diskon / 100), 0, ',', '.') }}</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <livewire:add-to-cart :productId="$prod->id" />
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Terjual 2000+ </li>
                                            <li>{{ $prod->created_at->since() }}</li>
                                            <li>LIFE: 60 days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tpproduct-btn">
                <div class="tpprduct-arrow tpproduct-btn__prv"><a href="#"><i class="icon-chevron-left"></i></a></div>
                <div class="tpprduct-arrow tpproduct-btn__nxt"><a href="#"><i class="icon-chevron-right"></i></a></div>
            </div>
        </div>
    </div>
    <x-prodkat></x-prodkat>
</div>
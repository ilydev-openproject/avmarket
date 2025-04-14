<div>
    <div class="product__filter-content mb-30">
        <div class="row d-flex align-items-center justify-content-between p-3">
            <div class="col d-flex justify-content-start">
                <div class="product__item-count">
                    <span>
                        Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} Produk
                    </span>
                </div>
            </div>

            <div class="col d-flex justify-content-end">
                <div class="" role="group">
                    <button wire:click="setSort('termurah')" type="button"
                        class="btn mx-2 {{ $sort === 'termurah' ? 'text-success-custom' : 'text-muted' }}">
                        Termurah
                    </button>

                    <button wire:click="setSort('terlaris')" type="button"
                        class="btn mx-2 {{ $sort === 'terlaris' ? 'text-success-custom' : 'text-muted' }}">
                        Terlaris
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-column">
            <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 tpproduct__shop-item">
                @foreach ($products as $product)
                <div class="col">
                    <div class="tpproduct p-relative mb-20">
                        <div class="tpproduct__thumb p-relative text-center">
                            <a href="toko/{{ $product->slug }}"><img src="{{ $product->getMedia('foto_product')->first()?->getUrl() }}" alt="{{$product->nama_product}}" style="aspect-ratio: 1/1; object-fit: cover;"></a>
                            <a class="tpproduct__thumb-img" href="toko/{{ $product->slug }}"><img src="{{ $product->getMedia('foto_product')->get(1)?->getUrl() }}" alt="{{$product->nama_product}}" style="aspect-ratio: 1/1; object-fit: cover;"></a>
                            <div class="tpproduct__info bage">
                                <span class="tpproduct__info-discount bage__discount">{{$product->diskon}}%</span>
                                <span class="tpproduct__info-hot bage__hot">{{ $product->label == 1 ? 'SUPER MURAH🔥' : 'MURAH' }}</span>
                            </div>
                            <div class="tpproduct__shopping">
                                <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                            </div>
                        </div>
                        <div class="tpproduct__content">
                            <span class="tpproduct__content-weight">
                                <a href="toko/{{ $product->slug }}">{{ ucfirst($product->kategori->nama_kategori) }}</a>
                            </span>
                            <h4 class="tpproduct__title">
                                <a href="toko/{{ $product->slug }}">{{ ucfirst($product->nama_product) }}</a>
                            </h4>
                            <div class="tpproduct__rating mb-5">
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                                <a href="#"><i class="icon-star_outline1"></i></a>
                            </div>
                            <div class="tpproduct__price">
                                <span>Rp{{ number_format($product->harga, 0, ',', '.') }}</span><br>
                                <del>Rp{{ number_format($product->harga + ($product->harga * $product->diskon / 100), 0, ',', '.') }}</del>
                            </div>
                        </div>
                        <div class="tpproduct__hover-text">
                            <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                <a class="tp-btn-2" href="">Add to cart</a>
                            </div>
                            <div class="tpproduct__descrip">
                                <ul>
                                    <li>Terjual {{ $product->terjual }}+ </li>
                                    <li>{{ $product->created_at->since() }}</li>
                                    <li>Jaminan Privasi Aman</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="basic-pagination text-center mt-35">
        {{ $products->links('vendor.pagination.custom') }}
    </div>
</div>
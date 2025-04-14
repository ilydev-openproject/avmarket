<div class="tpsidebar__product">
    <h4 class="tpsidebar__title mb-15">Recent Products</h4>
    @props(['recentProduct'])
    @foreach ($recentProduct as $recent)
    <div class="tpsidebar__product-item">
        <div class="tpsidebar__product-thumb p-relative">
            <img src="{{ $recent->getMedia('foto_product')->first()?->getUrl() }}" alt="foto_{{ $recent->nama_product}}" style="aspect-ratio: 1/1; object-fit: cover;">
            <div class="tpsidebar__info bage">
                <span class="tpproduct__info-discount bage__discount">{{$recent->diskon}}%</span>
                <span class="tpproduct__info-hot bage__hot">{{ $recent->label == 1 ? 'SUPER MURAH🔥' : 'MURAH' }}</span>
            </div>
        </div>
        <div class="tpsidebar__product-content">
            <span class="tpproduct__product-category">
                <a href="/toko/{{ $recent->slug }}">
                    <small class="tpproduct__content-weight">{{ ucwords($recent->kategori->nama_kategori) }}</small>
                </a>
            </span>
            <h4 class="tpsidebar__product-title">
                <a href="/toko/{{ $recent->slug }}">{{ $recent->nama_product }}</a>
            </h4>
            <div class="tpproduct__rating mb-5">
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
            </div>
            <div class="tpproduct__price">
                <span>Rp{{ number_format($recent->harga, 0, ',', '.') }}</span>
                <del>Rp{{ number_format($recent->harga + ($recent->harga * $recent->diskon / 100), 0, ',', '.') }}</del>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="tpshop__category">
    <div class="swiper-container inner-category-three">
        <div class="swiper-wrapper d-flex justify-content-start justify-content-xl-center">
            @foreach ($kategoris as $kat)
            <div class="swiper-slide">
                <div class="category__item mb-30">
                    <div class="category__thumb fix mb-15">
                        <a href="shop-details.html"><img src="{{ $kat->getFirstMediaUrl('foto_kategori') }}" alt="{{ ucwords($kat->nama_kategori) }}"></a>
                    </div>
                    <div class="category__content">
                        <h5 class="category__title text-truncate">
                            <a href="shop-details.html">{{ ucwords($kat->nama_kategori) }}</a>
                        </h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
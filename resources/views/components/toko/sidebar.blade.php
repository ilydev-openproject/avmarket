<div class="col-xl-2 col-lg-12 col-md-12">
    <div class="tpshop__leftbar">
        <div class="tpshop__widget mb-30 pb-25">
            <h4 class="tpshop__widget-title">Kategori Produk</h4>
            @props(['kategori'])
            @foreach ($kategori as $kat)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault9">
                <label class="form-check-label" for="flexCheckDefault9">
                    {{ ucwords($kat->nama_kategori) }}
                </label>
            </div>
            @endforeach

        </div>
        <div class="tpshop__widget mb-30 pb-25">
            <h4 class="tpshop__widget-title mb-20">FILTER BY PRICE</h4>
            <div class="productsidebar">
                <div class="productsidebar__head">
                </div>
                <div class="productsidebar__range">
                    <div id="slider-range"></div>
                    <div class="price-filter mt-10"><input type="text" id="amount">
                    </div>
                </div>
            </div>
            <div class="productsidebar__btn mt-15 mb-15">
                <a href="#">FILTER</a>
            </div>
        </div>
        <div class="tpshop__widget mb-30 pb-25">
            <h4 class="tpshop__widget-title mb-20">Filter by Color</h4>
            <div class="tpshop__widget-color-box">
                <div class="form-check">
                    <input class="form-check-input black-input" type="checkbox" checked value="" id="flexCheckDefault12">
                    <label class="form-check-label" for="flexCheckDefault12">
                        Black
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input blue-input" type="checkbox" value="" id="flexCheckChecked13">
                    <label class="form-check-label" for="flexCheckChecked13">
                        Blue
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input brown-input" type="checkbox" value="" checked id="flexCheckChecked18">
                    <label class="form-check-label" for="flexCheckChecked18">
                        Brown
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input grey-input" type="checkbox" checked value="" id="flexCheckChecked14">
                    <label class="form-check-label" for="flexCheckChecked14">
                        Gray
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input green-input" type="checkbox" value="" id="flexCheckChecked15">
                    <label class="form-check-label" for="flexCheckChecked15">
                        Green
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input orange-input" type="checkbox" value="" checked id="flexCheckChecked16">
                    <label class="form-check-label" for="flexCheckChecked16">
                        Yellow
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input red-input" type="checkbox" value="" id="flexCheckChecked17">
                    <label class="form-check-label" for="flexCheckChecked17">
                        Red
                    </label>
                </div>
            </div>
        </div>
        <div class="tpshop__widget mb-30 pb-25">
            <h4 class="tpshop__widget-title">FILTER BY BRAND</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault18">
                <label class="form-check-label" for="flexCheckDefault18">
                    Chrome Hearts (15)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" checked id="flexCheckDefault19">
                <label class="form-check-label" for="flexCheckDefault19">
                    Dominique Aurientis (15)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" checked id="flexCheckDefault20">
                <label class="form-check-label" for="flexCheckDefault20">
                    Galliano (15)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault21">
                <label class="form-check-label" for="flexCheckDefault21">
                    Georgine (15)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault22">
                <label class="form-check-label" for="flexCheckDefault22">
                    Matthew Christopher (15)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault23">
                <label class="form-check-label" for="flexCheckDefault23">
                    Paul Gaultier (15)
                </label>
            </div>
        </div>
        <div class="tpshop__widget">
            <h4 class="tpshop__widget-title">FILTER BY RATING</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault24">
                <label class="form-check-label" for="flexCheckDefault24">
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    (45)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" checked id="flexCheckDefault25">
                <label class="form-check-label" for="flexCheckDefault25">
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    (10)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault26">
                <label class="form-check-label" for="flexCheckDefault26">
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    (05)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" checked id="flexCheckDefault27">
                <label class="form-check-label" for="flexCheckDefault27">
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    (02)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault28">
                <label class="form-check-label" for="flexCheckDefault28">
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    <i class="icon-star_rate"></i>
                    (02)
                </label>
            </div>
        </div>
    </div>
    <div class="tpshop__widget">
        <div class="tpshop__sidbar-thumb mt-35">
            <img src="assets/img/shape/sidebar-product-1.png" alt="">
        </div>
    </div>
</div>
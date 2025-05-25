<footer>
    <!-- feature-area-start -->
    <section class="feature-area mainfeature__bg pt-50 pb-40"
        data-background="{{ asset('orfarm/assets/img/shape/footer-shape-1') }}.svg">
        <div class="container">
            <div class="mainfeature__border pb-15">
                <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2">
                    <div class="col">
                        <div class="mainfeature__item text-center mb-30">
                            <div class="mainfeature__icon">
                                <img src="{{ asset('orfarm/assets/img/icon/feature-icon-1.svg') }}" alt="">
                            </div>
                            <div class="mainfeature__content">
                                <h4 class="mainfeature__title">Pengiriman Cepat</h4>
                                <p>Lintas pulau jawa & Provinsi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mainfeature__item text-center mb-30">
                            <div class="mainfeature__icon">
                                <img src="{{ asset('orfarm/assets/img/icon/feature-icon-2.svg') }}" alt="">
                            </div>
                            <div class="mainfeature__content">
                                <h4 class="mainfeature__title">pembayaran aman</h4>
                                <p>100% Secure Payment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mainfeature__item text-center mb-30">
                            <div class="mainfeature__icon">
                                <img src="{{ asset('orfarm/assets/img/icon/feature-icon-3.svg') }}" alt="">
                            </div>
                            <div class="mainfeature__content">
                                <h4 class="mainfeature__title">Diskon Online</h4>
                                <p>Diskon dalam pembelian besar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mainfeature__item text-center mb-30">
                            <div class="mainfeature__icon">
                                <img src="{{ asset('orfarm/assets/img/icon/feature-icon-4.svg') }}" alt="">
                            </div>
                            <div class="mainfeature__content">
                                <h4 class="mainfeature__title">Help Center</h4>
                                <p>Layan tersedia 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mainfeature__item text-center mb-30">
                            <div class="mainfeature__icon">
                                <img src="{{ asset('orfarm/assets/img/icon/feature-icon-5.svg') }}" alt="">
                            </div>
                            <div class="mainfeature__content">
                                <h4 class="mainfeature__title">Item Pilihan</h4>
                                <p>Dari Pabrik Langsung</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- feature-area-end -->
    <div class="tpfooter__area theme-bg-2">
        <div class="tpfooter__top pb-15">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="tpfooter__widget footer-col-1 mb-50">
                            <h4 class="tpfooter__widget-title">Biarkan Kami Membantu Anda</h4>
                            <p>Jika anda ingin bertanya, silahkan <br> hubungi kami di:
                                <a href="mailto:hello@gamora.id">hello@gamora.id</a>
                            </p>
                            <div class="tpfooter__widget-social mt-45">
                                <span class="tpfooter__widget-social-title mb-5">Social Media:</span>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-skype"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="tpfooter__widget footer-col-2 mb-50">
                            <h4 class="tpfooter__widget-title">Mencari Gamora?</h4>
                            <p>Demak, Indonesia.</p>
                            <div class="tpfooter__widget-time-info mt-35">
                                <span>Senin – Sabtu: <b>8:10 AM – 4:00 PM</b></span>
                                <span>Sabtu: <b>10:10 AM – 4:00 PM</b></span>
                                <span>Minggu: <b>Tutup</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-5">
                        <div class="tpfooter__widget footer-col-3 mb-50">
                            <h4 class="tpfooter__widget-title">Kategori terlaris</h4>
                            <div class="tpfooter__widget-links">
                                <ul>
                                    @php
                                        use App\Models\Kategori;
                                        use App\Models\Product;

                                        $kategori = Kategori::with('product')->limit(5)->get();
                                    @endphp
                                    @foreach ($kategori as $kat)
                                        <li><a href="toko/{{$kat->slug}}">{{ ucfirst($kat->nama_kategori) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-7">
                        <div class="tpfooter__widget footer-col-4 mb-50">
                            <h4 class="tpfooter__widget-title">Berita Kami</h4>
                            <div class="tpfooter__widget-newsletter">
                                <p>Berlangganan email Gamora Herbal untuk menerima pembaruan
                                    tentang produk baru dan informasi lainnya.</p>
                                <form action="index.html">
                                    <span><i><img src="{{ asset('orfarm/assets/img/shape/message-1.svg') }}"
                                                alt=""></i></span>
                                    <input type="email" placeholder="Masukka Email Anda...">
                                    <button class="tpfooter__widget-newsletter-submit tp-news-btn">Langganan</button>
                                </form>
                                <div class="tpfooter__widget-newsletter-check mt-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I accept terms & conditions & privacy policy.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tpfooter___bottom pt-40 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-sm-12">
                        <div class="tpfooter__copyright">
                            <span class="tpfooter__copyright-text">Copyright 2025© <a href="#">GAMORA</a> all
                                rights reserved.</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 col-sm-12">
                        <div class="tpfooter__copyright-thumb text-end">
                            <img src="{{ asset('orfarm/assets/img/shape/footer-payment.png ') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-area-end -->
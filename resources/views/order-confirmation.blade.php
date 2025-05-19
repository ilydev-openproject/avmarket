<x-app>
    <!-- order-confirmation-area-start -->
    <section class="order-confirmation-area pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-8 col-md-11">
                    <div class="tperror__wrapper text-center">
                        <div class="tperror__thumb p-relative mb-55 d-flex justify-content-center text-center">
                            <dotlottie-player
                                src="https://lottie.host/8e650479-9e5c-40ed-8cc1-d1900f759657/LA7jjJrhHg.lottie"
                                background="transparent" speed="1" style="width: 300px; height: 300px" loop autoplay
                                loading="lazy"></dotlottie-player>
                        </div>
                        <div class="tperror__content">
                            <h4 class="tperror__title mb-25">Pesanan Anda Berhasil Dibuat!</h4>
                            <p>Terima kasih atas pembelian Anda. Pesanan Anda sedang diproses dan akan segera dikirim.
                                Cek email Anda untuk detail lebih lanjut.</p>
                            <div class="tperror__btn">
                                <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
                                <a href="{{ route('orders.history') }}" class="btn btn-outline-primary ml-10">Lihat
                                    Riwayat Pesanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order-confirmation-area-end -->
</x-app>
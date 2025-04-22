<x-app>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><a href="index.html">Home</a></span>
                            <span class="dvdr">/</span>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- checkout-area start -->
    <section class="checkout-area pb-50">
        <div class="container">
            <form action="#">
                <livewire:checkout-form />
            </form>
        </div>
    </section>
    <!-- checkout-area end -->
</x-app>
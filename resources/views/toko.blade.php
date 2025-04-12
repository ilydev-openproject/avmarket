<x-app>
    <x-toko.breadcrumb></x-toko.breadcrumb>

    <!-- shop-area-start -->
    <section class="shop-area-start grey-bg pb-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="tpshop__details">
                        <x-toko.kategori :kategoris="$kategoris" />
                        <livewire:produk-view />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-area-end -->
</x-app>
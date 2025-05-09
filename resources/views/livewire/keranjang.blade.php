<div>
    <!-- cart area -->
    <section class="cart-area pb-80">
        <div class="container">
            @forelse ($cart as $id => $item)
                <div class="row d-flex justify-content-between align-items-stretch">
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <div class="images">
                            <img src="{{ $item['gambar'] }}" class="img-fluid p-lg-4 p-0" alt="{{ $item['nama'] }}">
                        </div>
                    </div>
                    <div class="col-5 py-lg-5 py-2">
                        <div class="detail h-100 py-lg-5 py-2 d-flex justify-content-between align-items-center">
                            <div class="h-100 d-flex flex-column justify-content-between align-items-between me-5">
                                <div class="d-flex flex-column">
                                    <div class="product-name text mb-3 cust-prod">
                                        <a href="shop-details.html" class="d-block text-truncate"
                                            style="max-width: 100%;">{{ $item['nama'] }}</a>
                                    </div>
                                    <td class="product-price">
                                        <span class="amount">Rp{{ number_format($item['harga'], 0, ',', '.') }} | <text
                                                class="text-success">Stok Aman</text></span>
                                    </td>
                                </div>
                                <div>
                                    <td class="product-quantity">
                                        <div class="qty-btn d-flex justify-content-center align-items-center m-0">
                                            <span class="cart-minus cust-minus m-0"
                                                wire:click="decreaseQuantity({{ Auth::check() ? $item['id'] : $id }})">-</span>
                                            <input class="cart-input cust-qty m-0" type="text"
                                                value="{{ $item['quantity'] }}" readonly>
                                            <span class="cart-plus cust-plus m-0"
                                                wire:click="increaseQuantity({{ Auth::check() ? $item['id'] : $id }})">+</span>
                                        </div>
                                    </td>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 py-lg-5 py-2">
                        <div class="h-100 d-flex flex-column justify-content-between align-items-end py-lg-5 py-2">
                            <td class="product-price">
                                <span class="amount mb-5"><b>Rp{{ number_format($item['harga'], 0, ',', '.') }}</b></span>
                            </td>
                            <a href="#" wire:click.prevent="removeFromCart({{ Auth::check() ? $item['id'] : $id }})"
                                class="btn btn-outline-danger px-4 mt-5">
                                <i class="icon-trash"></i>
                                <span>Hapus</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border"></div>
            @empty
                <div>
                    <p class="text-center" style="font-size: 20px; font-weight: 600;">Keranjang kosong</p>
                </div>
            @endforelse
            @if (count($cart))
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value=""
                                                placeholder="Coupon code" type="text">
                                            <button class="tp-btn tp-color-btn banner-animation" name="apply_coupon"
                                                type="submit">
                                                Apply Coupon
                                            </button>
                                        </div>
                                        <!-- <div class="coupon2">
                                            <button class="tp-btn tp-color-btn banner-animation" name="update_cart" type="submit">
                                                Update cart
                                            </button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-md-5 ">
                                    <div class="cart-page-total">
                                        <h2>Cart totals</h2>
                                        <ul class="mb-20">
                                            <li>Total <span>Rp{{ number_format($total, 0, ',', '.') }}</span></li>
                                        </ul>
                                        <a href="/checkout" class="tp-btn tp-color-btn banner-animation">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </section>
    <!-- cart area end-->
</div>
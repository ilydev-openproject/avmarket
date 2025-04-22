<div class="tpcartinfo tp-cart-info-area p-relative">
    <button class="tpcart__close"><i class="icon-x"></i></button>
    <div class="tpcart">
        <h4 class="tpcart__title">Keranjang Anda</h4>
        <div class="tpcart__product">
            <div class="tpcart__product-list">
                @php
                $cartItems = array_slice($cart, 0, 5); // Ambil 5 item pertama
                $totalCartItems = count($cart);
                $remainingItems = $totalCartItems - count($cartItems);
                @endphp

                <ul>
                    @forelse($cartItems as $id => $item)
                    <li>
                        <div class="tpcart__item">
                            <div class="tpcart__img">
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}">
                                <div class="tpcart__del">
                                    <a href="#" wire:click.prevent="removeFromCart({{ $id }})">
                                        <i class="icon-x-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="tpcart__content">
                                <span class="tpcart__content-title">
                                    <a href="#">{{ $item['nama'] }}</a>
                                </span>
                                <div class="tpcart__cart-price">
                                    <span class="quantity">{{ $item['quantity'] }} x</span>
                                    <span class="new-price">Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li>
                        <p class="text-center">Keranjang kosong</p>
                    </li>
                    @endforelse

                    @if($remainingItems > 0)
                    <li class="text-center text-muted mt-2">
                        +{{ $remainingItems }} item lainnya
                    </li>
                    @endif
                </ul>
            </div>
            <div class="tpcart__checkout">
                <div class="tpcart__total-price d-flex justify-content-between align-items-center">
                    <span> Subtotal:</span>
                    <span class="heilight-price">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="tpcart__checkout-btn">
                    <a class="tpcart-btn mb-10" href="/keranjang">Lihat Keranjang</a>
                    <a class="tpcheck-btn" href="checkout.html">Checkout</a>
                </div>
            </div>
        </div>
        <div class="tpcart__free-shipping text-center">
            <span>Free ongkir untuk pengiriman <b>pulau jawa & bali</b></span>
        </div>
    </div>
</div>
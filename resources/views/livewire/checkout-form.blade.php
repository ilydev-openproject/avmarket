<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="checkbox-form">
            <h3>Rincian Pembayaran</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="country-select">
                        <label>Negara <span class="required">*</span></label>
                        <select class="form-select">
                            <option value="volvo">Indonesia</option>
                            <option value="saab">Luar Negri</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="checkout-form-list">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" placeholder="">
                    </div>
                </div>
                <div class="container">
                    @if($error)
                    <div class="alert alert-danger mb-4">{{ $error }}</div>
                    @endif

                    <div class="row">
                        <!-- Provinsi -->
                        <div class="col-md-6">
                            <div class="checkout-form-list mb-3">
                                <label>Provinsi</label>
                                <select wire:model.live="selectedProvince" class="form-select" wire:loading.attr="disabled">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Kabupaten/Kota -->
                        <div class="col-md-6">
                            <div class="checkout-form-list mb-3">
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Kabupaten/Kota</span>
                                    <div wire:loading.flex wire:target="selectedProvince" class="align-items-center">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <small class="text-muted ms-2">Memuat data kota...</small>
                                    </div>
                                </label>
                                <select wire:model.live="selectedCity" class="form-select"
                                    @if(!$selectedProvince || $isLoadingCities) disabled @endif
                                    wire:loading.attr="disabled">
                                    <option value="">-- Pilih Kabupaten --</option>
                                    @if($isLoadingCities)
                                    <option value="" disabled>Memuat data kabupaten...</option>
                                    @else
                                    @foreach($cities as $city)
                                    <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Options -->
                    <div class="my-4">
                        <h5 class="mb-3 fw-semibold border-bottom pb-2">Pilih Kurir Pengiriman</h5>
                        <!-- Loading State -->
                        <div class="text-center align-items-center " wire:loading.flex wire:target="selectedCity">
                            <div class="spinner-border text-primary me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="text-muted">Menghitung ongkos kirim...</span>
                        </div>

                        @if($isCalculatingShipping)
                        <!-- Still calculating (optional additional state) -->
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Pilih Provinsi dulu.
                        </div>
                        @elseif(count($shippingCosts) > 0)
                        <!-- Available Shipping Options -->
                        <div class="row g-3">
                            @foreach($shippingCosts as $index => $shipping)
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm {{ $selectedShipping == $index ? 'border-primary border-2' : '' }}"
                                    wire:click="selectShipping({{ $index }})"
                                    style="cursor: pointer;"
                                    role="button">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="form-check">
                                                    <input type="radio"
                                                        id="shipping-option-{{ $index }}"
                                                        wire:model="selectedShipping"
                                                        value="{{ $index }}"
                                                        class="form-check-input me-2">
                                                    <label class="form-check-label fw-bold mb-1" for="shipping-option-{{ $index }}">
                                                        {{ strtoupper($shipping['courier']) }}
                                                    </label>
                                                </div>
                                                <p class="text-muted small mb-1">{{ $shipping['service'] }}</p>
                                            </div>
                                            <span class="badge bg-light text-dark">
                                                {{ $shipping['etd'] }} hari
                                            </span>
                                        </div>
                                        <p class="small text-muted mb-2">{{ $shipping['description'] }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold fs-5">Rp {{ number_format($shipping['cost'], 0, ',', '.') }}</span>
                                            @if($selectedShipping == $index)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i> Terpilih
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <!-- No Shipping Available -->
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada layanan pengiriman tersedia untuk lokasi ini.
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="checkout-form-list">
                        <label>Alamat <span class="required">*</span></label>
                        <input type="text" placeholder="Nama jalan, RT/RW">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="checkout-form-list">
                        <label>Kecamatan <span class="required">*</span></label>
                        <input type="text" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="checkout-form-list">
                        <label>Kode Pos <span class="required">*</span></label>
                        <input type="text" placeholder="Kode Pos">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="checkout-form-list">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="checkout-form-list">
                        <label>Whatsapp <span class="required">*</span></label>
                        <input type="text" placeholder="Nomor Whatsapp">
                    </div>
                </div>
            </div>
            <div class="different-address">
                <!-- coupon-area start -->
                <section class="coupon-area pt-10 pb-30">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="coupon-accordion">
                                        <!-- ACCORDION START -->
                                        <h3>Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>
                                        <div id="checkout_coupon" class="coupon-checkout-content">
                                            <div class="coupon-info">
                                                <form action="#">
                                                    <p class="checkout-coupon">
                                                        <input type="text" placeholder="Coupon Code">
                                                        <button class="tp-btn tp-color-btn" type="submit">Apply Coupon</button>
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- ACCORDION END -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- coupon-area end -->
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="your-order mb-30 ">
            <h3>Pesanan Anda</h3>
            <div class="your-order-table table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th class="product-name">Produk</th>
                            <th class="product-total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $subtotal = 0;
                        $cartItems = session('cart', []);
                        @endphp
                        @forelse ($cartItems as $id => $item)
                        <tr class="cart_item">
                            <td class="product-name">
                                {{ $item['nama'] }} <strong class="product-quantity"> × {{ $item['quantity'] }}</strong>
                            </td>
                            <td class="product-total">
                                <span class="amount">Rp{{ number_format($item['harga']*$item['quantity'], 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @php
                        $subtotal += $item['harga'] * $item['quantity'];
                        @endphp
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4">
                                <p style="font-size: 20px; font-weight: 600;">Keranjang kosong</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="cart-subtotal">
                            <th>Cart Subtotal</th>
                            <td><span class="amount">Rp{{ number_format($subtotal, 0, ',', '.') }}</span></td>
                        </tr>
                        <tr class="shipping">
                            <th>Ongkir</th>
                            <td>
                                @if($selectedShipping !== null && isset($shippingCosts[$selectedShipping]))
                                <span class="amount">
                                    Rp{{ number_format($shippingCosts[$selectedShipping]['cost'], 0, ',', '.') }}
                                    ({{ strtoupper($shippingCosts[$selectedShipping]['courier']) }} - {{ $shippingCosts[$selectedShipping]['service'] }})
                                </span>
                                @php $shippingCost = $shippingCosts[$selectedShipping]['cost']; @endphp
                                @else
                                <span class="text-muted">Belum dipilih</span>
                                @php $shippingCost = 0; @endphp
                                @endif
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>Total Pesanan</th>
                            <td>
                                <strong>
                                    <span class="amount">Rp{{ number_format($subtotal + $shippingCost, 0, ',', '.') }}</span>
                                </strong>
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>
            <div class="payment-method">
                <div class="accordion" id="checkoutAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="checkoutOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#bankOne" aria-expanded="true" aria-controls="bankOne">
                                Transfer Bank
                            </button>
                        </h2>
                        <div id="bankOne" class="accordion-collapse collapse show" aria-labelledby="checkoutOne" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="paymentTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment" aria-expanded="false" aria-controls="payment">
                                Cheque Payment
                            </button>
                        </h2>
                        <div id="payment" class="accordion-collapse collapse" aria-labelledby="paymentTwo" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                Please send your cheque to Store Name, Store Street, Store Town, Store
                                State / County, Store
                                Postcode.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="paypalThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                                PayPal
                            </button>
                        </h2>
                        <div id="paypal" class="accordion-collapse collapse" aria-labelledby="paypalThree" data-bs-parent="#checkoutAccordion">
                            <div class="accordion-body">
                                Pay via PayPal; you can pay with your credit card if you don’t have a
                                PayPal account.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-button-payment mt-20">
                    <button type="submit" class="tp-btn tp-color-btn w-100 banner-animation">Place order</button>
                </div>
            </div>
        </div>
    </div>
</div>
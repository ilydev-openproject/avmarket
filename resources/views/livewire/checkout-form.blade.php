<form wire:submit.prevent="placeOrder">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="checkbox-form">
                <h3>Rincian Pembayaran</h3>
                @if (session()->has('message'))
                    <div class="alert alert-success mb-4">{{ session('message') }}</div>
                @endif
                @error('checkout')
                    <div class="alert alert-danger mb-4">{{ $message }}</div>
                @enderror

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
                    <livewire:location-selector :selectedProvinceId="$selectedProvince"
                        :selectedCityId="$selectedCity" />
                    <!-- Bagian alamat -->
                    <div class="col-md-12">
                        <div class="checkout-form-list">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" wire:model="customer_name" placeholder="Nama lengkap"
                                class="form-control">
                            @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkout-form-list">
                            <label>Alamat <span class="required">*</span></label>
                            <input type="text" wire:model="customer_address" placeholder="Nama jalan, RT/RW"
                                class="form-control">
                            @error('customer_address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkout-form-list">
                            <label>Kecamatan <span class="required">*</span></label>
                            <input type="text" wire:model="district" placeholder="Kecamatan" class="form-control">
                            @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkout-form-list">
                            <label>Kode Pos <span class="required">*</span></label>
                            <input type="text" wire:model="postal_code" placeholder="Kode Pos" class="form-control">
                            @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkout-form-list">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" wire:model="customer_email" placeholder="Email" class="form-control">
                            @error('customer_email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkout-form-list">
                            <label>Whatsapp <span class="required">*</span></label>
                            <input type="text" wire:model="customer_phone" placeholder="Nomor Whatsapp"
                                class="form-control">
                            @error('customer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Shipping Options -->
                    <div class="my-4">
                        <h5 class="mb-3 fw-semibold border-bottom pb-2">Pilih Kurir Pengiriman</h5>
                        <div class="text-center align-items-center" wire:loading.flex
                            wire:target="calculateShippingForAllCouriers">
                            <div class="spinner-border text-primary me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="text-muted">Menghitung ongkos kirim...</span>
                        </div>
                        @if($isCalculatingShipping)
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                Sedang menghitung ongkos kirim...
                            </div>
                        @elseif(count($shippingCosts) > 0)
                            <div class="row g-3">
                                @foreach($shippingCosts as $index => $shipping)
                                    <div class="col-md-6">
                                        <div class="card h-100 border-0 shadow-sm {{ $selectedShipping == $index ? 'border-primary border-2' : '' }}"
                                            wire:click="selectShipping({{ $index }})" style="cursor: pointer;" role="button">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="form-check">
                                                            <input type="radio" id="shipping-option-{{ $index }}"
                                                                wire:model="selectedShipping" value="{{ $index }}"
                                                                class="form-check-input me-2">
                                                            <label class="form-check-label fw-bold mb-1"
                                                                for="shipping-option-{{ $index }}">
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
                                                    <span class="fw-bold fs-5">Rp
                                                        {{ number_format($shipping['cost'], 0, ',', '.') }}</span>
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
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                Silakan pilih provinsi dan kota untuk melihat opsi pengiriman.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="your-order mb-30">
                <h3>Pesanan Anda</h3>
                <div class="your-order-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-name">Produk</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subtotal = 0;
                                $cartItems = Auth::check()
                                    ? App\Models\UserCart::where('id_user', Auth::id())->get()->map(function ($item) {
                                        $product = $item->product;
                                        if (!$product)
                                            return null;
                                        return [
                                            'product_id' => $product->id,
                                            'nama' => $product->nama_product,
                                            'harga' => $product->harga,
                                            'quantity' => $item->quantity,
                                        ];
                                    })->filter()->values()->toArray()
                                    : session()->get('cart', []);
                                if (!Auth::check()) {
                                    $cartItems = array_map(function ($item, $id) {
                                        return [
                                            'product_id' => $id,
                                            'nama' => $item['nama'],
                                            'harga' => $item['harga'],
                                            'quantity' => $item['quantity'],
                                        ];
                                    }, $cartItems, array_keys($cartItems));
                                }
                            @endphp
                            @forelse ($cartItems as $item)
                                <tr class="cart_item">
                                    <td class="product-name">
                                        {{ $item['nama'] }} <strong class="product-quantity"> ×
                                            {{ $item['quantity'] }}</strong>
                                    </td>
                                    <td class="product-total">
                                        <span
                                            class="amount">Rp{{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @php
                                    $subtotal += $item['harga'] * $item['quantity'];
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4">
                                        <p class="fs-5 fw-semibold">Keranjang kosong</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>Subtotal Keranjang</th>
                                <td><span class="amount">Rp{{ number_format($subtotal, 0, ',', '.') }}</span></td>
                            </tr>
                            <tr class="shipping">
                                <th>Ongkir</th>
                                <td>
                                    @if($selectedShipping !== null && isset($shippingCosts[$selectedShipping]))
                                        <span class="amount">
                                            Rp{{ number_format($shippingCosts[$selectedShipping]['cost'], 0, ',', '.') }}
                                            ({{ strtoupper($shippingCosts[$selectedShipping]['courier']) }} -
                                            {{ $shippingCosts[$selectedShipping]['service'] }})
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
                                        <span
                                            class="amount">Rp{{ number_format($subtotal + $shippingCost, 0, ',', '.') }}</span>
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
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#bankOne" aria-expanded="true" aria-controls="bankOne">
                                    Metode Pembayaran
                                </button>
                            </h2>
                            <div id="bankOne" class="accordion-collapse collapse show" aria-labelledby="checkoutOne"
                                data-bs-parent="#checkoutAccordion">
                                <div class="accordion-body">
                                    <div class="row g-3">
                                        <!-- BNI Card -->
                                        <div class="col-md-6">
                                            <div class="card h-100 border-0 shadow-sm {{ $selectedPaymentMethod == 'bni' ? 'border-primary border-2' : '' }}"
                                                style="cursor: pointer;"
                                                wire:click="$set('selectedPaymentMethod', 'bni')">
                                                <div stops="card-body text-center">
                                                    <input type="radio" class="form-check-input position-absolute"
                                                        style="top: 10px; right: 10px;" name="paymentMethod"
                                                        id="bniTransfer" value="bni" wire:model="selectedPaymentMethod">
                                                    <img src="{{ asset('/image/bank/bni.jpg') }}" alt="BNI"
                                                        class="img-fluid mb-3" style="max-height: 50px;">
                                                    <h6 class="card-title fw-bold mb-1">Transfer BNI</h6>
                                                    <p class="text-muted small">No. Rek: 1234 5678 9012</p>
                                                    <p class="text-muted small">Gamora Herbal Indonesia</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BCA Card -->
                                        <div class="col-md-6">
                                            <div class="card h-100 border-0 shadow-sm {{ $selectedPaymentMethod == 'bca' ? 'border-primary border-2' : '' }}"
                                                style="cursor: pointer;"
                                                wire:click="$set('selectedPaymentMethod', 'bca')">
                                                <div class="card-body text-center">
                                                    <input type="radio" class="form-check-input position-absolute"
                                                        style="top: 10px; right: 10px;" name="paymentMethod"
                                                        id="bcaTransfer" value="bca" wire:model="selectedPaymentMethod">
                                                    <img src="{{ asset('/image/bank/bca.jpg') }}" alt="BCA"
                                                        class="img-fluid mb-3" style="max-height: 50px;">
                                                    <h6 class="card-title fw-bold mb-1">Transfer BCA</h6>
                                                    <p class="text-muted small">No. Rek: 3456 7890 1234</p>
                                                    <p class="text-muted small">Gamora Herbal Indonesia</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- COD Card -->
                                        <div class="col-md-6">
                                            <div class="card h-100 border-0 shadow-sm {{ $selectedPaymentMethod == 'cod' ? 'border-primary border-2' : '' }}"
                                                style="cursor: pointer;"
                                                wire:click="$set('selectedPaymentMethod', 'cod')">
                                                <div class="card-body text-center">
                                                    <input type="radio" class="form-check-input position-absolute"
                                                        style="top: 10px; right: 10px;" name="paymentMethod" id="cod"
                                                        value="cod" wire:model="selectedPaymentMethod">
                                                    <img src="{{ asset('/image/bank/cod.jpg') }}" alt="COD"
                                                        class="img-fluid mb-3" style="max-height: 80px;">
                                                    <h6 class="card-title fw-bold mb-1">COD</h6>
                                                    <p class="text-muted small">Bayar di Tempat</p>
                                                    <p class="text-muted small">Gamora Herbal Indonesia</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span class="fw-semibold">Pembayaran dipilih:
                                            {{ strtoupper($selectedPaymentMethod) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol submit -->
                    <div class="order-button-payment mt-20">
                        <button type="submit" class="tp-btn tp-color-btn w-100 banner-animation"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Place order</span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin"></i> Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
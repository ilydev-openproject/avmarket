<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\UserCart;

class CheckoutForm extends Component
{
    // Address selection properties
    public $selectedProvince = null;
    public $selectedCity = null;
    public $customer_name = '';
    public $customer_address = '';
    public $district = '';
    public $postal_code = '';
    public $customer_email = '';
    public $customer_phone = '';
    public $error = null;

    // Shipping properties
    public $couriers = ['jne'];
    public $selectedCourier = 'jne';
    public $weight = 1;
    public $shippingCosts = [];
    public $isCalculatingShipping = false;
    public $originCityId = '113';
    public $selectedShipping = null;
    public $selectedPaymentMethod = 'bni';

    protected $listeners = [
        'location-selected' => 'updateLocation',
    ];

    public function mount()
    {
        \Log::info('CheckoutForm Mounted', [
            'user_id' => Auth::id(),
            'province_id' => $this->selectedProvince,
            'city_id' => $this->selectedCity
        ]);

        if ($this->selectedProvince && $this->selectedCity) {
            \Log::info('Auto-triggering Shipping Calculation', [
                'province_id' => $this->selectedProvince,
                'city_id' => $this->selectedCity
            ]);
            $this->calculateShippingForAllCouriers();
        }
    }

    public function updateLocation($location)
    {
        $oldCity = $this->selectedCity;
        $this->selectedProvince = $location['provinceId'];
        $this->selectedCity = $location['cityId'];

        \Log::info('UpdateLocation Called', [
            'provinceId' => $this->selectedProvince,
            'cityId' => $this->selectedCity,
            'oldCity' => $oldCity
        ]);

        if ($this->selectedCity && $oldCity !== $this->selectedCity) {
            \Log::info('Triggering Shipping Calculation', ['cityId' => $this->selectedCity]);
            $this->resetDependentFields('city');
            $this->calculateShippingForAllCouriers();
        }
    }

    protected function calculateShippingForAllCouriers()
    {
        $this->isCalculatingShipping = true;
        $this->shippingCosts = [];

        $cacheKey = "shipping_costs_{$this->originCityId}_{$this->selectedCity}_{$this->weight}";
        $this->shippingCosts = Cache::remember($cacheKey, now()->addHours(24), function () {
            $results = [];

            \Log::info('Starting Shipping Calculation', [
                'origin' => $this->originCityId,
                'destination' => $this->selectedCity,
                'weight' => $this->weight * 1000,
                'couriers' => $this->couriers
            ]);

            foreach ($this->couriers as $courier) {
                try {
                    $response = Http::withHeaders([
                        'key' => env('RAJAONGKIR_API_KEY')
                    ])->post('https://api.rajaongkir.com/starter/cost', [
                                'origin' => $this->originCityId,
                                'destination' => $this->selectedCity,
                                'weight' => $this->weight * 1000,
                                'courier' => $courier
                            ]);

                    $data = $response->json();
                    \Log::info('Shipping API Response', [
                        'courier' => $courier,
                        'status' => $response->status(),
                        'data' => $data
                    ]);

                    if ($response->successful() && ($data['rajaongkir']['status']['code'] ?? 0) === 200) {
                        $costs = $data['rajaongkir']['results'][0]['costs'] ?? [];
                        foreach ($costs as $service) {
                            $results[] = [
                                'courier' => strtoupper($courier),
                                'service' => $service['service'],
                                'description' => $service['description'],
                                'cost' => $service['cost'][0]['value'],
                                'etd' => $service['cost'][0]['etd']
                            ];
                        }
                    } else {
                        \Log::error('Shipping API Failed', [
                            'courier' => $courier,
                            'response' => $data
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error("Error calculating shipping for {$courier}: " . $e->getMessage());
                }
            }

            return $results;
        });

        \Log::info('Shipping Costs Populated', ['shippingCosts' => $this->shippingCosts]);
        $this->isCalculatingShipping = false;
    }

    public function selectShipping($index)
    {
        $this->selectedShipping = $index;
        $selectedService = $this->shippingCosts[$index] ?? null;
        $this->dispatch('shippingSelected', $selectedService);
        \Log::info('Shipping Selected', ['index' => $index, 'service' => $selectedService]);
    }

    protected function resetDependentFields($level)
    {
        $resets = [
            'city' => [
                'shippingCosts',
                'selectedCourier',
                'selectedShipping'
            ]
        ];

        $this->reset($resets[$level] ?? []);
        $this->reset('error');
    }

    public function placeOrder()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = [];
        if (Auth::check()) {
            $cartItems = UserCart::where('id_user', Auth::id())->get()->map(function ($item) {
                $product = $item->product;
                if (!$product)
                    return null;
                return [
                    'product_id' => $product->id,
                    'nama' => $product->nama_product,
                    'harga' => $product->harga,
                    'quantity' => $item->quantity,
                ];
            })->filter()->values()->toArray();
        } else {
            $cartItems = session()->get('cart', []);
            $cartItems = array_map(function ($item, $id) {
                return [
                    'product_id' => $id,
                    'nama' => $item['nama'],
                    'harga' => $item['harga'],
                    'quantity' => $item['quantity'],
                ];
            }, $cartItems, array_keys($cartItems));
        }

        if (empty($cartItems)) {
            $this->addError('checkout', 'Keranjang kosong. Tambahkan produk terlebih dahulu.');
            return;
        }

        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:500',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'selectedProvince' => 'required|numeric|min:1',
            'selectedCity' => 'required|numeric|min:1',
            'selectedShipping' => 'required',
            'selectedPaymentMethod' => 'required|in:bni,bca,cod',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_address.required' => 'Alamat wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'customer_email.required' => 'Email wajib diisi.',
            'customer_email.email' => 'Email tidak valid.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'selectedProvince.required' => 'Provinsi wajib dipilih.',
            'selectedProvince.min' => 'Provinsi tidak valid.',
            'selectedCity.required' => 'Kota wajib dipilih.',
            'selectedCity.min' => 'Kota tidak valid.',
            'selectedShipping.required' => 'Metode pengiriman wajib dipilih.',
            'selectedPaymentMethod.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        try {
            $shipping = $this->shippingCosts[$this->selectedShipping] ?? null;
            if (!$shipping) {
                $this->addError('checkout', 'Layanan pengiriman tidak valid.');
                return;
            }

            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['harga'] * $item['quantity'];
            }
            $total = $subtotal + $shipping['cost'];

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'customer_address' => $this->customer_address,
                'district' => $this->district,
                'postal_code' => $this->postal_code,
                'province_id' => $this->selectedProvince,
                'city_id' => $this->selectedCity,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping['cost'],
                'total' => $total,
                'shipping_courier' => $shipping['courier'],
                'shipping_service' => $this->selectedShipping,
                'payment_method' => $this->selectedPaymentMethod,
                'status' => 'pending',
            ]);

            $orderItems = [];
            foreach ($cartItems as $item) {
                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['nama'],
                    'price' => $item['harga'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['harga'] * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $order->items()->createMany($orderItems);

            if (Auth::check()) {
                UserCart::where('id_user', Auth::id())->delete();
            }
            session()->forget('cart');

            \Log::info('Order Placed', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'province_id' => $this->selectedProvince,
                'city_id' => $this->selectedCity,
                'total' => $total,
                'payment_method' => $this->selectedPaymentMethod,
                'items' => $orderItems
            ]);

            session()->flash('message', 'Pesanan berhasil dibuat!');
            return redirect()->route('order.confirmation', $order->id);
        } catch (\Exception $e) {
            $this->addError('checkout', 'Gagal membuat pesanan: ' . $e->getMessage());
            \Log::error('Order Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'province_id' => $this->selectedProvince,
                'city_id' => $this->selectedCity
            ]);
        }
    }

    public function render()
    {
        \Log::info('Rendering CheckoutForm', [
            'selectedCity' => $this->selectedCity,
            'shippingCosts' => $this->shippingCosts
        ]);
        return view('livewire.checkout-form');
    }
}
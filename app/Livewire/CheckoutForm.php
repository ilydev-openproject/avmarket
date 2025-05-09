<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutForm extends Component
{
    // Address selection properties
    public $selectedProvince = null;
    public $selectedCity = null;
    public $cities = [];
    public $isLoadingCities = false;
    public $error = null;
    public $provinces = [];

    // Shipping properties
    public $couriers = ['jne'];
    public $selectedCourier = 'jne';
    public $weight = 1;
    public $shippingCosts = [];
    public $isCalculatingShipping = false;
    public $originCityId = '113';
    public $selectedShipping = null;
    public $selectedPaymentMethod = 'bni';


    public function mount()
    {
        $this->loadProvinces();
    }

    // Load provinces from API
    public function loadProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/province');

            if ($response->successful()) {
                $data = $response->json();
                $this->provinces = $data['rajaongkir']['results'] ?? [];

                // Format data to match existing structure
                $this->provinces = array_map(function ($province) {
                    return [
                        'id' => $province['province_id'],
                        'name' => $province['province']
                    ];
                }, $this->provinces);
            } else {
                $this->error = "Failed to load provinces: " . ($data['rajaongkir']['status']['description'] ?? 'Unknown error');
            }
        } catch (\Exception $e) {
            $this->error = "Failed to load provinces: " . $e->getMessage();
            Log::error('Province load error: ' . $e->getMessage());
        }
    }

    // When province changes
    public function updatedSelectedProvince($provinceId)
    {
        $this->isLoadingCities = true;
        $this->resetDependentFields('province');
        $provinceId && $this->loadCities($provinceId);
        $this->isLoadingCities = false;
    }

    // Load cities from API
    public function loadCities($provinceId)
    {
        $this->isLoadingCities = true;
        $this->cities = [];
        $this->error = null;

        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/city', [
                        'province' => $provinceId
                    ]);

            if ($response->successful()) {
                $data = $response->json();

                // Format the response to match your expected structure
                $this->cities = array_map(function ($city) {
                    return [
                        'id' => $city['city_id'],
                        'name' => $city['type'] . ' ' . $city['city_name'] // e.g. "Kab. Bandung" or "Kota Bandung"
                    ];
                }, $data['rajaongkir']['results'] ?? []);

                // If empty results but no error
                if (empty($this->cities)) {
                    $this->error = "Tidak ada data kabupaten/kota untuk provinsi ini";
                }
            } else {
                $errorData = $response->json();
                $this->error = $errorData['rajaongkir']['status']['description'] ?? 'Gagal memuat data kabupaten/kota';
            }
        } catch (\Exception $e) {
            $this->error = "Terjadi kesalahan saat memuat kabupaten/kota: " . $e->getMessage();
            Log::error('City load error: ' . $e->getMessage());
        } finally {
            $this->isLoadingCities = false;
        }
    }

    public function updatedSelectedCity($cityId)
    {
        $this->resetDependentFields('city');

        if ($cityId) {
            // Otomatis hitung ongkir ketika kota dipilih
            $this->calculateShippingForAllCouriers();
        }
    }

    protected function calculateShippingForAllCouriers()
    {
        $this->isCalculatingShipping = true;
        $this->shippingCosts = [];
        $this->isCalculatingShipping = true;

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

                if ($response->successful() && ($data['rajaongkir']['status']['code'] ?? 0) === 200) {
                    $this->processCourierResults($courier, $data['rajaongkir']['results'][0]['costs'] ?? []);
                }
            } catch (\Exception $e) {
                Log::error("Error calculating shipping for {$courier}: " . $e->getMessage());
            }
        }

        $this->isCalculatingShipping = false;
    }

    public function selectShipping($index)
    {
        $this->selectedShipping = $index;

        // Anda bisa menyimpan data pengiriman yang dipilih disini
        $selectedService = $this->shippingCosts[$index] ?? null;
        // $this->emit('shippingSelected', $selectedService); // Jika perlu emit event
        $this->dispatch('shippingSelected', $selectedService);
    }

    // Method untuk memproses hasil ongkir
    protected function processCourierResults($courier, $costs)
    {
        foreach ($costs as $service) {
            $this->shippingCosts[] = [
                'courier' => strtoupper($courier),
                'service' => $service['service'],
                'description' => $service['description'],
                'cost' => $service['cost'][0]['value'],
                'etd' => $service['cost'][0]['etd']
            ];
        }
    }

    // Updated reset method to maintain consistency
    protected function resetDependentFields($level)
    {
        $resets = [
            'province' => [
                'selectedCity',
                'cities',
                'shippingCosts',
                'selectedCourier'
            ],
            'city' => [
                'shippingCosts',
                'selectedCourier'
            ]
        ];

        $this->reset($resets[$level] ?? []);
        $this->reset('error');
    }
    public function placeOrder()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login'); // arahkan ke halaman login jika belum login
        }

        // Validasi sederhana
        if (!$this->selectedCity || !$this->selectedShipping) {
            $this->addError('checkout', 'Silakan lengkapi alamat dan pilih metode pengiriman.');
            return;
        }

        // Simulasi proses order (di sini kamu bisa menyimpan ke database dsb.)
        $shipping = $this->shippingCosts[$this->selectedShipping] ?? null;

        if (!$shipping) {
            $this->addError('checkout', 'Layanan pengiriman tidak valid.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout-form');
    }
}

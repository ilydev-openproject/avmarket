<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Log;

class CitySelector extends Component
{
    public $selectedId = null;
    public $provinceId = null;
    public $cities = [];
    public $cityName = '';
    public $error = null;
    public $isLoading = false;

    public function mount($selectedId = null, $provinceId = null)
    {
        $this->selectedId = $selectedId;
        $this->provinceId = $provinceId;

        if ($this->provinceId) {
            $this->loadCities($this->provinceId);
        }
    }

    public function updatedProvinceId($value)
    {
        $this->isLoading = true;
        $this->selectedId = null;
        $this->cityName = '';
        $this->cities = [];

        if ($value) {
            $this->loadCities($value);
        }

        $this->isLoading = false;
        $this->dispatch('city-selected', $this->selectedId);

        \Log::info('Province ID Updated in CitySelector', [
            'provinceId' => $value,
            'cities_count' => count($this->cities)
        ]);
    }

    public function updatedSelectedId($value)
    {
        if ($value) {
            $city = array_filter($this->cities, fn($c) => $c['id'] == $value);
            $this->cityName = !empty($city) ? reset($city)['name'] : '';
        } else {
            $this->cityName = '';
        }

        // Emit event to sync with parent
        $this->dispatch('city-selected', $this->selectedId);

        \Log::info('Selected City Updated in CitySelector', [
            'selectedId' => $value,
            'city_name' => $this->cityName
        ]);
    }

    public function loadCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/city', [
                        'province' => $provinceId
                    ]);

            if ($response->successful()) {
                $this->cities = array_map(function ($city) {
                    return [
                        'id' => $city['city_id'],
                        'name' => $city['type'] . ' ' . $city['city_name']
                    ];
                }, $response->json()['rajaongkir']['results'] ?? []);

                // Set nama kota jika selectedId ada
                if ($this->selectedId) {
                    $city = array_filter($this->cities, fn($c) => $c['id'] == $this->selectedId);
                    $this->cityName = !empty($city) ? reset($city)['name'] : '';
                }

                \Log::info('Cities Loaded in CitySelector', ['provinceId' => $provinceId, 'count' => count($this->cities)]);
            } else {
                $this->error = 'Gagal memuat kota.';
                \Log::error('Cities Load Failed in CitySelector', ['response' => $response->json()]);
            }
        } catch (\Exception $e) {
            $this->error = 'Gagal memuat kota: ' . $e->getMessage();
            \Log::error('Cities Load Exception in CitySelector', ['error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.city-selector');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use App\Models\City;

class LocationSelector extends Component
{
    public $provinces = [];
    public $cities = [];
    public $selectedProvinceId = null;
    public $selectedCityId = null;
    public $provinceName = '';
    public $cityName = '';
    public $isLoadingCities = false;
    public $error = null;

    public function mount($selectedProvinceId = null, $selectedCityId = null)
    {
        $this->selectedProvinceId = $selectedProvinceId;
        $this->selectedCityId = $selectedCityId;
        $this->provinces = $this->getProvinces();

        if ($this->selectedProvinceId) {
            $this->cities = $this->getCities($this->selectedProvinceId);
            $province = array_filter($this->provinces, fn($p) => $p['id'] == $this->selectedProvinceId);
            $this->provinceName = !empty($province) ? reset($province)['name'] : '';
        }

        if ($this->selectedCityId) {
            $city = array_filter($this->cities, fn($c) => $c['id'] == $this->selectedCityId);
            $this->cityName = !empty($city) ? reset($city)['name'] : '';
        }

        \Log::info('LocationSelector Mounted', [
            'selectedProvinceId' => $this->selectedProvinceId,
            'selectedCityId' => $this->selectedCityId,
            'provinceName' => $this->provinceName,
            'cityName' => $this->cityName
        ]);
    }

    public function updatedSelectedProvinceId($value)
    {
        $this->isLoadingCities = true;
        $this->selectedCityId = null;
        $this->cityName = '';
        $this->cities = [];
        $this->error = null;

        if ($value) {
            $province = array_filter($this->provinces, fn($p) => $p['id'] == $value);
            if (empty($province)) {
                $this->error = 'Provinsi tidak valid.';
                $this->selectedProvinceId = null;
                $this->provinceName = '';
            } else {
                $this->cities = $this->getCities($value);
                $this->provinceName = reset($province)['name'];
            }
        } else {
            $this->provinceName = '';
        }

        $this->dispatch('location-selected', [
            'provinceId' => $this->selectedProvinceId,
            'cityId' => $this->selectedCityId
        ]);
        $this->isLoadingCities = false;
    }

    public function updatedSelectedCityId($value)
    {
        $this->error = null;

        if ($value) {
            $city = array_filter($this->cities, fn($c) => $c['id'] == $value);
            if (empty($city)) {
                $this->error = 'Kota tidak valid.';
                $this->selectedCityId = null;
                $this->cityName = '';
            } else {
                $this->cityName = reset($city)['name'];
            }
        } else {
            $this->cityName = '';
        }

        \Log::info('Dispatching location-selected', [
            'provinceId' => $this->selectedProvinceId,
            'cityId' => $this->selectedCityId
        ]);

        $this->dispatch('location-selected', [
            'provinceId' => $this->selectedProvinceId,
            'cityId' => $this->selectedCityId
        ]);
    }

    protected function getProvinces()
    {
        $provinces = Province::select('province_id as id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        if (!empty($provinces)) {
            \Log::info('Provinces fetched from database', ['count' => count($provinces)]);
            return $provinces;
        }

        return Cache::remember('rajaongkir_provinces', now()->addDays(30), function () {
            try {
                $response = Http::withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
                    ->get('https://api.rajaongkir.com/starter/province');
                $data = $response->json();
                \Log::info('Provinces API Response', ['status' => $response->status(), 'data' => $data]);

                if ($response->successful() && ($data['rajaongkir']['status']['code'] ?? 0) === 200) {
                    $provinces = array_map(function ($p) {
                        Province::updateOrCreate(
                            ['province_id' => $p['province_id']],
                            ['name' => $p['province']]
                        );
                        return [
                            'id' => $p['province_id'],
                            'name' => $p['province']
                        ];
                    }, $data['rajaongkir']['results'] ?? []);
                    return $provinces;
                }
                return [];
            } catch (\Exception $e) {
                \Log::error('Error fetching provinces: ' . $e->getMessage());
                return [];
            }
        });
    }

    protected function getCities($provinceId)
    {
        $cities = City::select('city_id as id', \DB::raw("CONCAT(type, ' ', name) as name"))
            ->where('province_id', $provinceId)
            ->orderBy('name')
            ->get()
            ->toArray();

        if (!empty($cities)) {
            \Log::info('Cities fetched from database', ['province_id' => $provinceId, 'count' => count($cities)]);
            return $cities;
        }

        return Cache::remember("rajaongkir_cities_{$provinceId}", now()->addDays(30), function () use ($provinceId) {
            try {
                $response = Http::withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
                    ->get('https://api.rajaongkir.com/starter/city', ['province' => $provinceId]);
                $data = $response->json();
                \Log::info('Cities API Response', ['provinceId' => $provinceId, 'status' => $response->status(), 'data' => $data]);

                if ($response->successful() && ($data['rajaongkir']['status']['code'] ?? 0) === 200) {
                    $cities = array_map(function ($c) use ($provinceId) {
                        City::updateOrCreate(
                            ['city_id' => $c['city_id']],
                            [
                                'province_id' => $provinceId,
                                'type' => $c['type'],
                                'name' => $c['city_name']
                            ]
                        );
                        return [
                            'id' => $c['city_id'],
                            'name' => $c['type'] . ' ' . $c['city_name']
                        ];
                    }, $data['rajaongkir']['results'] ?? []);
                    return $cities;
                }
                return [];
            } catch (\Exception $e) {
                \Log::error('Error fetching cities: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function render()
    {
        return view('livewire.location-selector');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Log;

class ProvinceSelector extends Component
{
    public $selectedId = null;
    public $provinces = [];
    public $provinceName = '';
    public $error = null;

    public function mount($selectedId = null)
    {
        $this->selectedId = $selectedId;
        $this->loadProvinces();
    }

    public function loadProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/province');

            if ($response->successful()) {
                $this->provinces = array_map(function ($province) {
                    return [
                        'id' => $province['province_id'],
                        'name' => $province['province']
                    ];
                }, $response->json()['rajaongkir']['results'] ?? []);

                // Set nama provinsi jika selectedId ada
                if ($this->selectedId) {
                    $province = array_filter($this->provinces, fn($p) => $p['id'] == $this->selectedId);
                    $this->provinceName = !empty($province) ? reset($province)['name'] : '';
                }

                \Log::info('Provinces Loaded in ProvinceSelector', ['count' => count($this->provinces)]);
            } else {
                $this->error = 'Gagal memuat provinsi.';
                \Log::error('Provinces Load Failed in ProvinceSelector', ['response' => $response->json()]);
            }
        } catch (\Exception $e) {
            $this->error = 'Gagal memuat provinsi: ' . $e->getMessage();
            \Log::error('Provinces Load Exception in ProvinceSelector', ['error' => $e->getMessage()]);
        }
    }

    public function updatedSelectedId($value)
    {
        if ($value) {
            $province = array_filter($this->provinces, fn($p) => $p['id'] == $value);
            $this->provinceName = !empty($province) ? reset($province)['name'] : '';
        } else {
            $this->provinceName = '';
        }

        // Emit event to sync with parent
        $this->dispatch('province-selected', $this->selectedId);

        \Log::info('Selected Province Updated in ProvinceSelector', [
            'selectedId' => $value,
            'province_name' => $this->provinceName
        ]);
    }

    public function render()
    {
        return view('livewire.province-selector');
    }
}
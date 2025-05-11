<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Profile extends Component
{
    public $name, $email, $created_at;
    public $selectedProvince = null;
    public $selectedCity = null;
    public $cities = [];
    public $isLoadingCities = false;
    public $error = null;
    public $provinces = [];

    public function mount()
    {
        $user = auth()->user();

        if (!is_object($user)) {
            return redirect('/login');
        }
        $this->loadProvinces();

        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->created_at = $user->created_at->format('M Y') ?? '';
    }
    public function updateProfile()
    {
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('message', 'Profil berhasil diperbarui!');
    }

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
        }
    }
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
        } finally {
            $this->isLoadingCities = false;
        }
    }
    public function updatedSelectedCity($cityId)
    {
        $this->resetDependentFields('city');

        if ($cityId) {

        }
    }
    protected function resetDependentFields($level)
    {
        $resets = [
            'province' => [
                'selectedCity',
                'cities',
            ],
        ];

        $this->reset($resets[$level] ?? []);
        $this->reset('error');
    }
    public function render()
    {
        return view('livewire.profile');
    }
}

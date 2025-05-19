<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\City;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil provinsi
        $response = Http::withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
            ->get('https://api.rajaongkir.com/starter/province');
        $data = $response->json();

        if ($response->successful() && ($data['rajaongkir']['status']['code'] ?? 0) === 200) {
            foreach ($data['rajaongkir']['results'] as $province) {
                Province::updateOrCreate(
                    ['province_id' => $province['province_id']],
                    ['name' => $province['province']]
                );

                // Ambil kota untuk setiap provinsi
                $cityResponse = Http::withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
                    ->get('https://api.rajaongkir.com/starter/city', ['province' => $province['province_id']]);
                $cityData = $cityResponse->json();

                if ($cityResponse->successful() && ($cityData['rajaongkir']['status']['code'] ?? 0) === 200) {
                    foreach ($cityData['rajaongkir']['results'] as $city) {
                        City::updateOrCreate(
                            ['city_id' => $city['city_id']],
                            [
                                'province_id' => $province['province_id'],
                                'type' => $city['type'],
                                'name' => $city['city_name']
                            ]
                        );
                    }
                }
            }
        }
    }
}
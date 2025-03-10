<?php

namespace Database\Factories;

use App\Models\Mobil;
use Illuminate\Database\Eloquent\Factories\Factory;

class MobilFactory extends Factory
{
    protected $model = Mobil::class;

    public function definition(): array
    {
        $carData = [
            'Toyota' => [
                'All New Veloz' => 400000,
                'Zenix Hybrid' => 650000,
                'Hilux' => 500000,
                'Hiace' => 1500000,
                'Alphard' => 3000000,
            ],
            'Daihatsu' => [
                'All New Xenia' => 400000,
            ],
            'Mitsubishi' => [
                'Pajero Sport' => 650000,
            ],
        ];
        $descriptions = ['Lepas Kunci', 'Dengan Driver'];

        $merk = $this->faker->randomElement(array_keys($carData));
        $type = $this->faker->randomElement(array_keys($carData[$merk]));
        $price = $carData[$merk][$type];

        return [
            'type' => $type,
            'merk' => $merk,
            'price' => $price, // harga rental perharinya
            'description' => $this->faker->randomElement($descriptions),
            // 'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}

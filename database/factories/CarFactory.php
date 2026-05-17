<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $cars = [
            'Audi' => ['A4', 'A6', 'Q5'],
            'BMW' => ['320i', '530d', 'X5'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan'],
            'Toyota' => ['Corolla', 'Avensis', 'RAV4']
        ];

        $brand = array_rand($cars);
        $model = $cars[$brand][array_rand($cars[$brand])];

        return [

            'reg_number' => strtoupper($this->faker->bothify('???###')),
            'brand' => $brand,
            'model' => $model,
            'owner_id' => null, // Bus priskirta seeder'yje
        ];
    }
}

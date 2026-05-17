<?php

namespace database\seeders;

use App\Models\Owner;
use App\Models\Car;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        Owner::factory(10)->create()->each(function ($owner) {

            $carCount = rand(1, 3);

            Car::factory($carCount)->create([
                'owner_id' => $owner->id
            ]);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create();

        User::factory()->count(4)->create();

        Owner::factory()->count(10)->create()->each(function ($owner) {
            Car::factory()->count(rand(1, 3))->create([
                'owner_id' => $owner->id,
            ]);
        });
    }
}

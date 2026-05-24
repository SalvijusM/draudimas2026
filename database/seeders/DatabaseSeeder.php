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
        $viewers = User::factory()->count(2)->create();
        $regulars = User::factory()->count(2)->regular()->create();
        $allUsers = $viewers->concat($regulars);
        Owner::factory()->count(10)->create()->each(function ($owner, $index) use ($allUsers) {

            if ($index < $allUsers->count()) {
                $owner->update([
                    'user_id' => $allUsers[$index]->id
                ]);
            }

            Car::factory()->count(rand(1, 3))->create([
                'owner_id' => $owner->id,
            ]);
        });
    }
}

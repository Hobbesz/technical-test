<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Turbine;
use App\Models\User;
use App\Models\WindFarm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        User::factory([
                'email' => 'toby.lerone@email.com',
                'name' => 'Toby Lerone',
            ])
            ->has(WindFarm::factory([
                    'latitude' => 54.85087258269527,
                    'longitude' => -2.1555459520003812,
                ])
                ->count(2)
                ->has(Turbine::factory()
                    ->count(6)
                    ->has(Part::factory()->count(5))))
            ->create();

        User::factory()
            ->count(3)
            ->has(WindFarm::factory()
                ->count(2)
                ->has(Turbine::factory()
                    ->count(6)
                    ->has(Part::factory()->count(5))))
            ->create();
        DB::commit();
    }
}

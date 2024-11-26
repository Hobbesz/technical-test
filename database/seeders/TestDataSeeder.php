<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Note;
use App\Models\Part;
use App\Models\Turbine;
use App\Models\User;
use App\Models\WindFarm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        Account::factory()
            ->count(2)
            ->has(User::factory()->count(3))
            ->has(WindFarm::factory()
                ->count(2)
                ->has(Turbine::factory()
                    ->count(6)
                    ->has(Part::factory()->count(5)->has(Note::factory()))))
            ->create();
        DB::commit();
    }
}

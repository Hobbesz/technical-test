<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WindFarm>
 */
class WindFarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'name' => $this->faker->name(),
            'latitude' => $this->faker->randomFloat(5, -90, 90),
            'longitude' => $this->faker->randomFloat(5, -180, 180),
        ];
    }
}

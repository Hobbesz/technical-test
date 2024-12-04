<?php

namespace Database\Factories;

use App\Models\WindFarm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turbine>
 */
class TurbineFactory extends Factory
{
    const MAX_POSITION_OFFSET = 0.02;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'wind_farm_id' => WindFarm::factory(),
            'name' => $this->faker->name(),
            'x_position_offset' => $this->faker->randomFloat(5, -1 * self::MAX_POSITION_OFFSET, self::MAX_POSITION_OFFSET),
            'y_position_offset' => $this->faker->randomFloat(5, -1 * self::MAX_POSITION_OFFSET, self::MAX_POSITION_OFFSET),
        ];
    }
}

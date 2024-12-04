<?php

namespace Database\Factories;

use App\Models\Turbine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'turbine_id' => Turbine::factory(),
            'name' => $this->faker->randomElement(['Blade', 'Rotor', 'Hub', 'Generator']),
            'condition_rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}

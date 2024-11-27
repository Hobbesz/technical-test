<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class WindFarmTest extends TestCase
{
    /**
     * Test wind farms structure is correct.
     *
     * @return void
     */
    public function test_the_api_returns_a_list_of_wind_farms()
    {
        $this->actingAs(User::first(), 'sanctum');
        $response = $this->get('/api/wind-farms');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'account_id',
                    'name',
                    'latitude',
                    'longitude',
                    'created_at',
                    'updated_at',
                    'laravel_through_key',
                    'turbines' => [
                        '*' => [
                            'id',
                            'wind_farm_id',
                            'name',
                            'x_position_offset',
                            'y_position_offset',
                            'created_at',
                            'updated_at',
                            'parts' => [
                                '*' => [
                                    'id',
                                    'turbine_id',
                                    'name',
                                    'condition_rating',
                                    'created_at',
                                    'updated_at',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test unauthorized response without providing auth.
     *
     * @return void
     */
    public function test_the_api_returns_unauthorized()
    {
        $response = $this->get('/api/wind-farms');

        $response->assertStatus(401);
    }
}

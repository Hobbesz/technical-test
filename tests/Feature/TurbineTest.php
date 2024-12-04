<?php

namespace Tests\Feature;

use App\Models\Turbine;
use App\Models\WindFarm;
use App\Models\User;
use Tests\TestCase;

class TurbineTest extends TestCase
{
    private $jsonStructure = [
        'wind_farm_id',
        'name',
        'x_position_offset',
        'y_position_offset',
        'created_at',
        'updated_at',
    ];

    /**
     * Test turbines structure is correct for index.
     *
     * @return void
     */
    public function test_the_api_returns_a_list_of_turbines()
    {
        $user = $this->retrieveUser();
        $windFarm = WindFarm::whereHas('user', fn ($q) => $q->where('id', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$windFarm->id}/turbines");

        $response->assertStatus(200);
        array_push($this->jsonStructure, 'id');
        $response->assertJsonStructure([
            'data' => [
                '*' => $this->jsonStructure,
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
        $response = $this->get('/api/wind-farms/1/turbines');

        $response->assertStatus(401);
    }

    /**
     * Test turbines structure is correct for show.
     *
     * @return void
     */
    public function test_the_api_returns_an_individual_turbine()
    {
        $user = $this->retrieveUser();
        $turbine = Turbine::whereHas('windFarm.user', fn ($q) => $q->where('id', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$turbine->windFarm->id}/turbines/{$turbine->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);
    }

    /**
     * Test turbines show endpoint rejects access to invalid turbine.
     *
     * @return void
     */
    public function test_the_api_rejects_request_when_invalid_turbine()
    {
        $user = $this->retrieveUser();
        $turbine = Turbine::whereHas('windFarm.user', fn ($q) => $q->where('id', '<>', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$turbine->windFarm->id}/turbines/{$turbine->id}");

        $response->assertStatus(404);
    }
}

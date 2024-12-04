<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WindFarm;
use Tests\TestCase;

class WindFarmTest extends TestCase
{
    private $jsonStructure = [
        'user_id',
        'name',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
    ];

    /**
     * Test wind farms structure is correct for index.
     *
     * @return void
     */
    public function test_the_api_returns_a_list_of_wind_farms()
    {
        $this->actingAs(User::first(), 'sanctum');
        $response = $this->get('/api/wind-farms');

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
        $response = $this->get('/api/wind-farms');

        $response->assertStatus(401);
    }

    /**
     * Test wind farms structure is correct for show.
     *
     * @return void
     */
    public function test_the_api_returns_an_individual_wind_farm()
    {
        $user = $this->retrieveUser();
        $windFarm = WindFarm::whereHas('user', fn ($q) => $q->where('id', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$windFarm->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);
    }

    /**
     * Test wind farms show endpoint rejects access to invalid wind farm.
     *
     * @return void
     */
    public function test_the_api_rejects_request_when_invalid_wind_farm()
    {
        $user = $this->retrieveUser();
        $windFarm = WindFarm::whereHas('user', fn ($q) => $q->where('id', '<>', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$windFarm->id}");

        $response->assertStatus(404);
    }

    /**
     * Test wind farm deletion works.
     *
     * @return void
     */
    public function test_the_api_deletes_a_wind_farm()
    {
        $user = $this->retrieveUser();
        $windFarm = WindFarm::whereHas('user', fn ($q) => $q->where('id', $user->id))->firstOrFail();

        $response = $this->delete("/api/wind-farms/{$windFarm->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('wind_farms', [
            'id' => $windFarm->id,
        ]);
    }

    /**
     * Test wind farms can only be deleted if the wind farm belongs to the same user.
     *
     * @return void
     */
    public function test_the_api_returns_404_for_deleting_an_inaccessible_wind_farm()
    {
        $user = $this->retrieveUser();
        $windFarm = WindFarm::whereHas('user', fn ($q) => $q->where('id', '<>', $user->id))->firstOrFail();

        $response = $this->delete("/api/wind-farms/{$windFarm->id}");
        $response->assertStatus(404);
    }
}

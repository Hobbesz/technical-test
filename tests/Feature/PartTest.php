<?php

namespace Tests\Feature;

use App\Models\Part;
use App\Models\Turbine;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class PartTest extends TestCase
{
    private $jsonStructure = [
        'turbine_id',
        'name',
        'condition_rating',
        'created_at',
        'updated_at',
    ];

    /**
     * Test parts structure is correct for index.
     *
     * @return void
     */
    public function test_the_api_returns_a_list_of_parts()
    {
        $user = $this->retrieveUser();
        $turbine = Turbine::whereHas('windFarm.user', fn ($q) => $q->where('id', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$turbine->windFarm->id}/turbines/{$turbine->id}/parts");

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
        $response = $this->get('/api/wind-farms/1/turbines/1/parts');

        $response->assertStatus(401);
    }

    /**
     * Test parts structure is correct for show.
     *
     * @return void
     */
    public function test_the_api_returns_an_individual_part()
    {
        $user = $this->retrieveUser();
        $part = Part::whereHas('turbine.windFarm.user', fn ($q) => $q->where('id', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$part->turbine->windFarm->id}/turbines/{$part->turbine->id}/parts/{$part->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);
    }

    /**
     * Test parts show endpoint rejects access to invalid part
     *
     * @return void
     */
    public function test_the_api_rejects_request_when_invalid_part()
    {
        $user = $this->retrieveUser();
        $part = Part::whereHas('turbine.windFarm.user', fn ($q) => $q->where('id', '<>', $user->id))->firstOrFail();
        $response = $this->get("/api/wind-farms/{$part->turbine->windFarm->id}/turbines/{$part->turbine->id}/parts/{$part->id}");

        $response->assertStatus(404);
    }

    /**
     * Test parts update endpoint updates a part
     *
     * @return void
     */
    public function test_the_api_updates_a_part()
    {
        $user = $this->retrieveUser();
        $part = Part::whereHas('turbine.windFarm.user', fn ($q) => $q->where('id', $user->id))->firstOrFail();

        $response = $this->patch(
            "/api/wind-farms/{$part->turbine->windFarm->id}/turbines/{$part->turbine->id}/parts/{$part->id}",
            [
                'condition_rating' => 1,
            ],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);

        $newPartData = Arr::get($response->decodeResponseJson(), 'data');

        $this->assertEquals(1, $newPartData['condition_rating']);
        $this->assertDatabaseHas('parts',[
            'id' => $newPartData['id'],
            'condition_rating' => 1,
        ]);
    }
}

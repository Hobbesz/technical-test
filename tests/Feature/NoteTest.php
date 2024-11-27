<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\Part;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class NoteTest extends TestCase
{
    private $noteStructure = [
        'id',
        'part_id',
        'text',
        'created_at',
        'updated_at'
    ];

    /**
     * Test notes index structure is correct.
     *
     * @return void
     */
    public function test_the_api_returns_a_list_of_notes()
    {
        $user = $this->retrieveUser();
        $part = $this->retrievePart($user);

        $response = $this->get("/api/parts/{$part->id}/notes");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => $this->noteStructure,
            ],
        ]);
    }

    /**
     * Test notes can't be viewed unless they belong to the same account.
     *
     * @return void
     */
    public function test_the_api_returns_404_for_inaccessible_notes()
    {
        $user = $this->retrieveUser();
        $part = $this->retrieveInvalidPart($user);

        $response = $this->get("/api/parts/{$part->id}/notes");
        $response->assertStatus(404);
    }

    /**
     * Test note creation works.
     *
     * @return void
     */
    public function test_the_api_creates_a_note()
    {
        $user = $this->retrieveUser();
        $part = $this->retrievePart($user);

        $noteText = 'Lorem ipsum';
        $response = $this->post("/api/parts/{$part->id}/notes", [
            'text' => $noteText,
        ]);
        $newNote = Arr::get($response->decodeResponseJson(), 'data');

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->noteStructure,
        ]);
        $this->assertEquals($noteText, $newNote['text']);
        $this->assertDatabaseHas('notes',[
            'id' => $newNote['id'],
            'text' => $noteText,
        ]);
    }

    /**
     * Test notes can only be created if the part belongs to the same account.
     *
     * @return void
     */
    public function test_the_api_returns_404_for_creating_a_note_on_an_inaccessible_part()
    {
        $user = $this->retrieveUser();
        $part = $this->retrieveInvalidPart($user);

        $response = $this->post("/api/parts/{$part->id}/notes", ['text' => 'Lorem ipsum']);
        $response->assertStatus(404);
    }

    /**
     * Test notes can only be created with valid data.
     *
     * @return void
     */
    public function test_the_api_validates_note_text_length()
    {
        $user = $this->retrieveUser();
        $part = $this->retrievePart($user);

        $response = $this->post("/api/parts/{$part->id}/notes", ['text' => Str::random(1001)]);
        $response->assertStatus(422);

        $response = $this->post("/api/parts/{$part->id}/notes", ['text' => Str::random(1000)]);
        $response->assertStatus(201);
    }

    /**
     * Test note show structure is correct.
     *
     * @return void
     */
    public function test_the_api_returns_an_individual_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveNote($user);

        $response = $this->get("/api/parts/{$note->part->id}/notes/{$note->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->noteStructure,
        ]);
    }

    /**
     * Test note show only works for valid users.
     *
     * @return void
     */
    public function test_the_api_returns_404_to_an_inaccessible_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveInvalidNote($user);

        $response = $this->get("/api/parts/{$note->part->id}/notes/{$note->id}");
        $response->assertStatus(404);
    }

    /**
     * Test note update works.
     *
     * @return void
     */
    public function test_the_api_updates_a_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveNote($user);

        $noteText = 'Lorem ipsum';
        $response = $this->patch("/api/parts/{$note->part->id}/notes/{$note->id}", [
            'text' => $noteText,
        ]);
        $newNote = Arr::get($response->decodeResponseJson(), 'data');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->noteStructure,
        ]);
        $this->assertEquals($noteText, $newNote['text']);
        $this->assertDatabaseHas('notes',[
            'id' => $newNote['id'],
            'text' => $noteText,
        ]);
    }

    /**
     * Test notes can only be updated if the part belongs to the same account.
     *
     * @return void
     */
    public function test_the_api_returns_404_for_updating_an_inaccessible_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveInvalidNote($user);

        $response = $this->patch("/api/parts/{$note->part->id}/notes/{$note->id}", ['text' => 'Lorem ipsum']);
        $response->assertStatus(404);
    }

    /**
     * Test notes can only be updated with valid data.
     *
     * @return void
     */
    public function test_the_api_validates_note_text_length_when_updating()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveNote($user);

        $response = $this->patch("/api/parts/{$note->part->id}/notes/{$note->id}", ['text' => Str::random(1001)]);
        $response->assertStatus(422);

        $response = $this->patch("/api/parts/{$note->part->id}/notes/{$note->id}", ['text' => Str::random(1000)]);
        $response->assertStatus(200);
    }

    /**
     * Test note deletion works.
     *
     * @return void
     */
    public function test_the_api_deletes_a_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveNote($user);

        $response = $this->delete("/api/parts/{$note->part->id}/notes/{$note->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }

    /**
     * Test notes can only be deleted if the part belongs to the same account.
     *
     * @return void
     */
    public function test_the_api_returns_404_for_deleting_an_inaccessible_note()
    {
        $user = $this->retrieveUser();
        $note = $this->retrieveInvalidNote($user);

        $response = $this->delete("/api/parts/{$note->part->id}/notes/{$note->id}");
        $response->assertStatus(404);
    }

    /**
     * Retrieve a part to make requests against.
     * 
     * @param   App\Models\User
     * @return  App\Models\Part
     */
    private function retrievePart($user)
    {
        return Part::whereHas('turbine.windFarm.account.users', fn ($q) => $q->where('id', $user->id))->firstOrFail();
    }

    /**
     * Retrieve an invalid part to make requests against.
     * 
     * @param   App\Models\User
     * @return  App\Models\Part
     */
    private function retrieveInvalidPart($user)
    {
        return Part::whereHas('turbine.windFarm.account.users', fn ($q) => $q->where('account_id', '<>', $user->account->id))->firstOrFail();
    }

    /**
     * Retrieve a note to make requests against.
     * 
     * @param   App\Models\User
     * @return  App\Models\Note
     */
    private function retrieveNote($user)
    {
        return Note::whereHas('part.turbine.windFarm.account.users', fn ($q) => $q->where('id', $user->id))->firstOrFail();
    }

    /**
     * Retrieve an invalid note to make requests against.
     * 
     * @param   App\Models\User
     * @return  App\Models\Note
     */
    private function retrieveInvalidNote($user)
    {
        return Note::whereHas('part.turbine.windFarm.account.users', fn ($q) => $q->where('account_id', '<>', $user->account->id))->firstOrFail();
    }
}

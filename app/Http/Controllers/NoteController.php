<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($partId)
    {
        $part = $this->getPart($partId);
        
        return new ResourceCollection($part->notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $partId)
    {
        $part = $this->getPart($partId);
        $validatedData = $this->validateRequestData($request);
        $note = $part->notes()->create($validatedData);

        return new JsonResource($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $partId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($partId, $id)
    {
        $note = $this->getNote($id, $partId);

        return new JsonResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $partId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $partId, $id)
    {
        $note = $this->getNote($id, $partId);
        $validatedData = $this->validateRequestData($request);
        $note->text = $validatedData['text'];
        $note->save();

        return new JsonResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $partId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($partId, $id)
    {
        $note = $this->getNote($id, $partId);
        try {
            $note->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete Note:{$note->id}. {$e}");
        }
    }

    /**
     * Retrieve the part for the given id using the auth context.
     *
     * @param  int  $id
     * @return \App\Models\Part
     */
    private function getPart($id)
    {
        $user = User::find(Auth::id());
        $part = Part::where('id', $id)
            ->whereHas('turbine.windFarm.account.users', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->first();

        if (!isset($part)) {
            throw new NotFoundHttpException();
        }

        return $part;
    }

    /**
     * Retrieve the note for the given id using the auth context.
     *
     * @param  int  $id
     * @param  int  $partId
     * @return \App\Models\Note
     */
    private function getNote($id, $partId)
    {
        $user = User::find(Auth::id());
        $note = Note::where('id', $id)
            ->where('part_id', $partId)
            ->whereHas('part.turbine.windFarm.account.users', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->first();

        if (!isset($note)) {
            throw new NotFoundHttpException();
        }

        return $note;
    }

    /**
     * Validate the request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateRequestData($request)
    {
        return $request->validate([
            'text' => ['required', 'max:1000'],
        ]);
    }
}

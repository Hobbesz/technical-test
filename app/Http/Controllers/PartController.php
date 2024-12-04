<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param   int $windFarmId
     * @param   int $turbineId
     * 
     * @return \Illuminate\Http\Response
     */
    public function index($windFarmId, $turbineId)
    {
        $user = User::find(Auth::id());
        $turbine = Turbine::whereHas('windFarm', function ($query) use ($user, $windFarmId) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('id', $windFarmId);
        })->where('id', $turbineId)->first();

        if (!isset($turbine)) {
            throw new NotFoundHttpException();
        }

        return new ResourceCollection($turbine->parts()->get());
    }

    /**
     * Display an individual resource.
     *
     * @param   int $windFarmId
     * @param   int $turbineId
     * @param   int $id
     * 
     * @return  \Illuminate\Http\Response
     */
    public function show($windFarmId, $turbineId, $id)
    {
        $part = $this->getPart($windFarmId, $turbineId, $id);

        return new JsonResource($part);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $windFarmId
     * @param  int  $turbineId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $windFarmId, $turbineId, $id)
    {
        $part = $this->getPart($windFarmId, $turbineId, $id);
        $validatedData = $request->validate([
            'condition_rating' => [Rule::in(range(1, 5))],
        ]);
        $part->condition_rating = $validatedData['condition_rating'];
        $part->save();

        return new JsonResource($part);
    }

    /**
     * Retrieve the part for the given id using the auth context.
     *
     * @param  int $windFarmId
     * @param  int $turbineId
     * @param  int $id
     * @return \App\Models\Part
     */
    private function getPart($windFarmId, $turbineId, $id)
    {
        $user = User::find(Auth::id());

        $part = Part::whereHas('turbine', function ($query) use ($user, $windFarmId, $turbineId) {
            $query->whereHas('windFarm', function ($query) use ($windFarmId, $user) {
                $query->whereHas('user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                })->where('id', $windFarmId);
            })->where('id', $turbineId);
        })->where('id', $id)->first();

        if (!isset($part)) {
            throw new NotFoundHttpException();
        }

        return $part;
    }
}

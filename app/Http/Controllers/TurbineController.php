<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use App\Models\User;
use App\Models\WindFarm;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TurbineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param   int $windFarmId
     * 
     * @return \Illuminate\Http\Response
     */
    public function index($windFarmId)
    {
        $user = User::find(Auth::id());
        $windFarm = WindFarm::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->where('id', $windFarmId)->first();

        if (!isset($windFarm)) {
            throw new NotFoundHttpException();
        }

        return new ResourceCollection($windFarm->turbines()->get());
    }

    /**
     * Display an individual resource.
     *
     * @param   int $windFarmId
     * @param   int $id
     * 
     * @return  \Illuminate\Http\Response
     */
    public function show($windFarmId, $id)
    {
        $user = User::find(Auth::id());
        $turbine = Turbine::whereHas('windFarm', function ($query) use ($windFarmId, $user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('id', $windFarmId);
        })->where('id', $id)->first();

        if (!isset($turbine)) {
            throw new NotFoundHttpException();
        }

        return new JsonResource($turbine);
    }
}

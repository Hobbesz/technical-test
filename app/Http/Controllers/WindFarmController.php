<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WindFarm;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WindFarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        return new ResourceCollection($user->windFarms()->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $windFarm = $this->getWindFarm($id);
        return new JsonResource($windFarm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $windFarm = $this->getWindFarm($id);
        $windFarm->delete();

        return new JsonResource($windFarm);
    }

    /**
     * Retrieve the wind farm for the given id using the auth context.
     *
     * @param  int $id
     * @return \App\Models\Part
     */
    private function getWindFarm($id)
    {
        $user = User::find(Auth::id());

        $windFarm = WindFarm::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->where('id', $id)->first();

        if (!isset($windFarm)) {
            throw new NotFoundHttpException();
        }

        return $windFarm;
    }
}

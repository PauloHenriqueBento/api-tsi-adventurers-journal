<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePaisRequest;
use App\Http\Resources\PaisResource;
use App\Http\Resources\UserResource;
use App\Models\Pais;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pais = Pais::all();
        return PaisResource::collection($pais);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdatePaisRequest $request)
    {
        $data = $request->validated();
        $pais = Pais::create($data);

        return new PaisResource($pais);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $pais = Pais::findOrFail($id);
            return new PaisResource($pais);
        }catch(ModelNotFoundException $e){
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pais $pais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdatePaisRequest $request, string $id)
    {
        $pais = Pais::findOrfail($id);
        $data = $request->all();
        $pais->update($data);
        return new PaisResource($pais);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pais = Pais::findOrFail($id)->delete();
        return response()->json([], 204);
    }
}

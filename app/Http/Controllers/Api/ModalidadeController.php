<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateModalidadeRequest;
use App\Http\Resources\ModalidadeResource;
use App\Models\Modalidade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ModalidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades = Modalidade::all();
        return ModalidadeResource::collection($modalidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateModalidadeRequest $request)
    {
        $data = $request->validated();
        $modalidades = Modalidade::create($data);

        return new ModalidadeResource($modalidades);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $modalidades = Modalidade::findOrFail($id);
            return new ModalidadeResource($modalidades);
        }catch(ModelNotFoundException){
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateModalidadeRequest $request, string $id)
    {
        $modalidades = Modalidade::findOrFail($id);
        $data = $request->all();
        $modalidades->update($data);
        return new ModalidadeResource($modalidades);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modalidades = Modalidade::findOrFail($id)->delete();
        return response()->json([], 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use App\Http\Resources\DestinoResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDestinoRequest;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinos = Destino::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de destinos retornada',
            'destinos' => DestinoResource::collection($destinos)
        ], 200);
    }
    
    public function store(StoreDestinoRequest $request)
    {
        $destino = new Destino();

        $destino->nome = $request->nome;
        $destino->descricao = $request->descricao;
        $destino->cidade_id = $request->cidade_id;
        $destino->CEP = $request->CEP;

        $destino->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Novo destino criado',
            'destino' => new DestinoResource($destino)
        ], 200);
    }

    
    public function show(string $id)
    {
        try{
            $destino = Destino::findOrFail($id);
            return new DestinoResource($destino);
        }catch(ModelNotFoundException $e){
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    public function update(StoreDestinoRequest $request, string $id)
    {
        $destino = Destino::findOrfail($id);
        $data = $request->all();

        $destino->update($data);

        return response()->json([
            'status' => 200,
            'mensagem' => 'Destino atualizado'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destino = Destino::find($id);

        if (!$destino) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $destino->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }
}

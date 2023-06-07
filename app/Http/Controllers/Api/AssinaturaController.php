<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assinatura;
use App\Http\Resources\AssinaturaResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssinaturaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssinaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assinaturas = Assinatura::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de assinaturas retornada',
            'assinaturas' => AssinaturaResource::collection($assinaturas)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssinaturaRequest $request)
    {
        $assinatura = new Assinatura();

        $assinatura->nome = $request->nome;
        $assinatura->preco = $request->preco;

        $assinatura->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Nova assinatura criada',
            'destino' => new AssinaturaResource($assinatura)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        try{
            $assinatura = Assinatura::findOrFail($id);
            return new AssinaturaResource($assinatura);
        }catch(ModelNotFoundException $e){
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAssinaturaRequest $request, string $id)
    {
        $assinatura = Assinatura::findOrfail($id);
        $data = $request->all();

        $assinatura->update($data);

        return response()->json([
            'status' => 200,
            'mensagem' => 'Assinatura atualizada'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assinatura = Assinatura::find($id);

        if (!$assinatura) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $assinatura->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }
}

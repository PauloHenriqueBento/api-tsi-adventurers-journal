<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estado;
use App\Http\Resources\EstadoResource;
use App\Http\Resources\PaisResource;
use App\Http\Requests\StoreEstadoRequest;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de estados retornado',
            'estados' => EstadoResource::collection($estados)
        ], 200);
    }

    public function store(StoreEstadoRequest $request)
    {
        $estado = new Estado();

        $estado->nome = $request->nome;
        $estado->uf = $request->uf;


        $uf = $request->input('uf');
        $exists = Estado::where('uf', $uf)->exists();// verificar se o UF já existe no banco de dados


        if($exists){
            return response()->json([
                'status' => 200,
                'mensagem' => 'UF já existe'
            ], 200);
        }else{
            $estado->save();

            return response()->json([
                'status' => 200,
                'mensagem' => 'Estado criado',
                'estado' => new EstadoResource($estado)
            ], 200);
        }
    }

    public function update(StoreEstadoRequest $request, string $id)
    {
        $estado = Estado::findOrfail($id);
        $data = $request->all();

        $uf = $request->input('uf');
        $exists = Estado::where('uf', $uf)->exists();// verificar se o UF já existe no banco de dados

        if ($exists) {
            return response()->json([
                'status' => 200,
                'mensagem' => 'UF já existe'
            ], 200);
        } else {
            $estado->update($data);
            //return new PaisResource($pais);

            return response()->json([
                'status' => 200,
                'mensagem' => 'Estado atualizado'
            ], 200);
        }
    }


    public function destroy(string $id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $estado->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }
}

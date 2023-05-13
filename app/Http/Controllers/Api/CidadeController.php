<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Http\Resources\CidadeResource;
use App\Http\Requests\StoreCidadeRequest;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = Cidade::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de cidades retornado',
            'cidades' => CidadeResource::collection($cidades)
        ], 200);
    }

    public function store(StoreCidadeRequest $request)
    {
        $cidade = new Cidade();

        $cidade->nome = $request->nome;
        $cidade->estado_id = $request->estado_id;

        $cidade->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Cidade criado',
            'cidade' => new CidadeResource($cidade)
        ], 200);
    }

    public function show(string $id)
    {
        try{
            $cidade = Cidade::findOrFail($id);
            return new CidadeResource($cidade);
        }catch(ModelNotFoundException $e){
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    public function update(StoreCidadeRequest $request, string $id)
    {
        $cidade = Cidade::findOrfail($id);
        $data = $request->all();

        $cidade->update($data);
        //return new PaisResource($pais);

        return response()->json([
            'status' => 200,
            'mensagem' => 'Cidade atualizado'
        ], 200);
    }


    public function destroy(string $id)
    {
        $cidade = Cidade::find($id);

        if (!$cidade) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $cidade->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }
}

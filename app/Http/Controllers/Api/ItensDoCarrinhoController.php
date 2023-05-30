<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ItensDoCarrinho;
use App\Http\Resources\ItensDoCarrinhoResource;
use App\Http\Requests\StoreItensDoCarrinhoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItensDoCarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = ItensDoCarrinho::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de carrinho retornado',
            'carrinho' => ItensDoCarrinhoResource::collection($carrinho)
        ], 200);
    }

    public function store(StoreItensDoCarrinhoRequest $request)
    {
        $carrinho = new ItensDoCarrinho();

        $carrinho->idViajante = $request->idViajante;
        $carrinho->idAtividade = $request->idAtividade;
        $carrinho->qtdPessoa = $request->qtdPessoa;

        $carrinho->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Carrinho criado',
            'carrinho' => new ItensDoCarrinhoResource($carrinho)
        ], 200);
    }

    public function show(string $id)
    {
        try {
            $carrinho = ItensDoCarrinho::findOrFail($id);
            return new ItensDoCarrinhoResource($carrinho);
        } catch (ModelNotFoundException $e) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    public function update(StoreItensDoCarrinhoRequest $request, string $id)
    {
        $carrinho = ItensDoCarrinho::findOrfail($id);
        $data = $request->all();

        $carrinho->update($data);
        //return new PaisResource($pais);

        return response()->json([
            'status' => 200,
            'mensagem' => 'carrinho atualizado',
            'carrinho' => new ItensDoCarrinhoResource($carrinho)
        ], 200);
    }

    public function destroy(string $id)
    {
        $carrinho = ItensDoCarrinho::find($id);

        if (!$carrinho) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $carrinho->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }
}

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
    public function index(Request $request)
    {
        $idViajante = auth()->id();
        $query = ItensDoCarrinho::query();
        $query = $query->where('idViajante', $idViajante);
        // $carrinho = ItensDoCarrinho::where('idViajante', $idViajante)->get();

        // Filtro por modalidade
        if ($request->has('cart')) {
            $cart = $request->query('cart') ?? '';
            $itens = !empty($cart) ? explode(',', $cart) : [];
            $query->whereIn('id', $itens);
        }

        $carrinho = $query->get();

        if ($carrinho->isEmpty()) {
            return response()->json(['message' => 'Nenhum item'], 200);
        }

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de carrinho retornada',
            'carrinho' => ItensDoCarrinhoResource::collection($carrinho)
        ], 200);
    }

    public function store(StoreItensDoCarrinhoRequest $request)
    {
        $carrinho = new ItensDoCarrinho();

        $carrinho->idViajante = auth()->id();
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

            // Verificar se o usuário autenticado é o criador do item
            if ($carrinho->idViajante !== auth()->id()) {
                return response()->json([
                    'status' => 401,
                    'mensagem' => 'Não autorizado'
                ], 401);
            }

            return new ItensDoCarrinhoResource($carrinho);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Item não encontrado'
            ], 404);
        }
    }

    public function update(StoreItensDoCarrinhoRequest $request, string $id)
    {
        $carrinho = ItensDoCarrinho::findOrFail($id);

        // Verificar se o usuário autenticado é o dono do carrinho
        if ($carrinho->idViajante !== auth()->id()) {
            return response()->json([
                'status' => 401,
                'mensagem' => 'Não autorizado'
            ], 401);
        }

        $carrinho->qtdPessoa = $request->qtdPessoa;
        $carrinho->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Carrinho atualizado',
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

        // Verificar se o usuário autenticado é o dono do carrinho
        if ($carrinho->idViajante !== auth()->id()) {
            return response()->json([
                'status' => 401,
                'mensagem' => 'Não autorizado'
            ], 401);
        }

        $carrinho->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }

    public function destroyAll()
    {
        $idViajante = auth()->id();

        // Apagar todos os itens do carrinho do usuário autenticado
        ItensDoCarrinho::where('idViajante', $idViajante)->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Todos os itens do carrinho foram apagados'
        ], 200);
    }
}

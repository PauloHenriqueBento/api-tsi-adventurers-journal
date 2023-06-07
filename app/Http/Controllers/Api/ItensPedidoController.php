<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItensPedido;
use App\Http\Resources\ItensPedidoResource;
use App\Http\Requests\StoreItensPedidoRequest;
use App\Models\ItensDoCarrinho;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ItensPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUsuario = auth()->id();

        $itens = ItensPedido::where('idUsuario', $idUsuario)->get();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de itens do pedido retornada',
            'itens_do_pedido' => ItensPedidoResource::collection($itens)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItensPedidoRequest $request)
    {
        $idViajante = auth()->id();
        $query = ItensDoCarrinho::query();
        $query->where('idViajante', $idViajante);

        if ($request->has('cart')) {
            $cart = $request->input('cart') ?? '';
            $itens = !empty($cart) ? explode(',', $cart) : [];
            $query->whereIn('id', $itens);
        }

        $itensCarrinho = $query->get();


        // Verificar se o carrinho está vazio
        if ($itensCarrinho->isEmpty()) {
            return response()->json([
                'status' => 200,
                'mensagem' => 'Carrinho vazio. Nenhum item adicionado ao pedido'
            ], 200);
        }

        // Codigo
        $codigoAleatorio = Str::random(7); // Gera uma sequência aleatória com 7 caracteres
        $codigoGerado = 'ADVENTURE' . $codigoAleatorio;

        // Validar o valor de FormaPag
        $formaPagamento = $request->input('FormaPag');
        $formasPagamentoPermitidas = ['boleto', 'pix', 'cartao'];
        if (!in_array($formaPagamento, $formasPagamentoPermitidas)) {
            return response()->json([
                'status' => 400,
                'mensagem' => 'Forma de pagamento inválida. As opções permitidas são: boleto, PIX, Cartão'
            ], 400);
        }

        //Preço total
        $totalPrice = $request->input('totalPrice');

        // Criar um novo item do pedido para cada item do carrinho
        $itensPedido = [];

        foreach ($itensCarrinho as $itemCarrinho) {
            $itemPedido = new ItensPedido();
            $itemPedido->codigo_gerado = $codigoGerado;
            $itemPedido->idUsuario = $idViajante;
            $itemPedido->idAtividade = $itemCarrinho->idAtividade;
            $itemPedido->qtdPessoa = $itemCarrinho->qtdPessoa;
            $itemPedido->DatadoPedido = Carbon::now(); // Definir a data atual
            $itemPedido->TotalPedido = $totalPrice; // Calcular o total
            $itemPedido->FormaPag = $formaPagamento;
            $itemPedido->status = 'pendente';
            $itemPedido->save();

            $itensPedido[] = $itemPedido;
            $itemCarrinho->delete();
        }


        return response()->json([
            'status' => 200,
            'mensagem' => 'Novos itens adicionados',
            'itens do pedido' => ItensPedidoResource::collection($itensPedido)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idUsuario = auth()->id();

        $itens = ItensPedido::where('id', $id)->where('idUsuario', $idUsuario)->first();

        if (!$itens) {
            return response()->json([
                'status' => 401,
                'mensagem' => 'Não autorizado'
            ], 401);
        }

        return new ItensPedidoResource($itens);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreItensPedidoRequest $request, string $id)
    {
        $itens = ItensPedido::findOrFail($id);

        // Verificar se o usuário atual é o proprietário do item do pedido
        if ($itens->idUsuario != auth()->id()) {
            return response()->json([
                'status' => 401,
                'mensagem' => 'Acesso não autorizado. Você não pode atualizar este item do pedido'
            ], 401);
        }

        // Atualizar apenas o status do item do pedido
        $status = $request->input('status') ?? '';
        $nota = $request->input('nota');
        $comentario = $request->input('comentario');
        if ($status)
            if ($status != 'aprovado' && $status != 'cancelado' && $status != 'pendente') {
                return response()->json([
                    'status' => 400,
                    'mensagem' => 'Status inválido. Os valores permitidos são: aprovado, cancelado'
                ], 400);
            }

        if ($status)
            $itens->status = $status ?? '';
        $itens->nota = $nota ?? '';
        $itens->comentario = $comentario ?? '';
        $itens->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Item do pedido atualizado'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itens = ItensPedido::find($id);

        if (!$itens) {
            return response()->json([
                'status' => 404,
                'mensagem' => 'Registro não existe'
            ], 404);
        }

        $itens->delete();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Deletado com sucesso'
        ], 200);
    }

    public function listByUserId($idUsuario)
    {
        $user = User::find($idUsuario);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $itens = ItensPedido::where('idUsuario', $idUsuario)->get();

        if ($itens->isEmpty()) {
            return response()->json(['message' => 'Nenhum item do pedido encontrado'], 200);
        }

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de itens do pedido retornada',
            'itens_do_pedido' => ItensPedidoResource::collection($itens)
        ], 200);
    }
}

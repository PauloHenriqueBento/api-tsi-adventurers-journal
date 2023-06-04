<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItensPedido;
use App\Http\Resources\ItensPedidoResource;
use App\Http\Requests\StoreItensPedidoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItensPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itens = ItensPedido::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de itens do pedido retornada',
            'destinos' => ItensPedidoResource::collection($itens)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItensPedidoRequest $request)
    {
        $itens = new ItensPedido();

        $itens->idUsuario = $request->idUsuario;
        $itens->idAtividade = $request->idAtividade;
        $itens->status = $request->status;
        $itens->DatadoPedido = $request->DatadoPedido;
        $itens->TotalPedido = $request->TotalPedido;
        $itens->FormaPag = $request->FormaPag;
        $itens->qtdPessoa = $request->qtdPessoa;

        $itens->save();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Novo item adicionado',
            'itens do pedido' => new ItensPedidoResource($itens)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $itens = ItensPedido::findOrFail($id);
            return new ItensPedidoResource($itens);
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
    public function update(StoreItensPedidoRequest $request, string $id)
    {
        $itens = ItensPedido::findOrfail($id);
        $data = $request->all();

        $itens->update($data);

        return response()->json([
            'status' => 200,
            'mensagem' => 'Itens atualizados'
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
}

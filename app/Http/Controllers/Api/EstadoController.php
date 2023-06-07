<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estado;
use App\Http\Resources\EstadoResource;
use App\Http\Resources\PaisResource;
use App\Http\Requests\StoreEstadoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EstadoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/estado",
     *     summary="Obter lista de estados",
     *     operationId="getEstados",
     *     tags={"Estados"},
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="mensagem", type="string", example="Lista de estados retornada"),
     *         @OA\Property(property="estados", type="array", @OA\Items(ref="#/components/schemas/EstadoSchema"))
     *     )),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function index()
    {
        $estados = Estado::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de estados retornado',
            'estados' => EstadoResource::collection($estados)
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/estado",
     *     summary="Criar novo estado",
     *     operationId="createEstado",
     *     tags={"Estados"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EstadoRequestBody")
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="mensagem", type="string", example="Estado criado"),
     *         @OA\Property(property="estado", ref="#/components/schemas/EstadoSchema")
     *     )),
     *     @OA\Response(response="400", description="Requisição inválida"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function store(StoreEstadoRequest $request)
    {
        $estado = new Estado();

        $estado->nome = $request->nome;
        $estado->uf = $request->uf;
        $estado->pais_id = $request->pais_id;


        $uf = $request->input('uf');
        $exists = Estado::where('uf', $uf)->exists(); // verificar se o UF já existe no banco de dados


        if ($exists) {
            return response()->json([
                'status' => 200,
                'mensagem' => 'UF já existe'
            ], 200);
        } else {
            $estado->save();

            return response()->json([
                'status' => 200,
                'mensagem' => 'Estado criado',
                'estado' => new EstadoResource($estado)
            ], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/estado/{id}",
     *     summary="Obter informações de um estado",
     *     operationId="getEstado",
     *     tags={"Estados"},
     *     @OA\Parameter(
     *
     *         name="id",
     *         required=true,
     *         in="path",
     *         description="ID do estado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(ref="#/components/schemas/EstadoSchema")),
     *     @OA\Response(response="404", description="Estado não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function show(string $id)
    {
        try {
            $estado = Estado::findOrFail($id);
            return new EstadoResource($estado);
        } catch (ModelNotFoundException $e) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/estado/{id}",
     *     summary="Atualizar informações de um estado",
     *     operationId="updateEstado",
     *     tags={"Estados"},
     *     @OA\Parameter(
     *         name="id",
     *         required=true,
     *         in="path",
     *         description="ID do estado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EstadoRequestBody")
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="mensagem", type="string", example="Estado atualizado")
     *     )),
     *     @OA\Response(response="400", description="Requisição inválida"),
     *     @OA\Response(response="404", description="Estado não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function update(StoreEstadoRequest $request, string $id)
    {
        $estado = Estado::findOrfail($id);
        $data = $request->all();

        $uf = $request->input('uf');
        $exists = Estado::where('uf', $uf)->exists(); // verificar se o UF já existe no banco de dados

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

    /**
     * @OA\Delete(
     *     path="/estado/{id}",
     *     summary="Excluir um estado",
     *     operationId="deleteEstado",
     *     tags={"Estados"},
     *     @OA\Parameter(
     *         name="id",
     *         required=true,
     *         in="path",
     *         description="ID do estado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="mensagem", type="string", example="Deletado com sucesso")
     *     )),
     *     @OA\Response(response="404", description="Estado não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
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

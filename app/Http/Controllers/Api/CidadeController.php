<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Http\Resources\CidadeResource;
use App\Http\Requests\StoreCidadeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CidadeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cidade",
     *     summary="Obter lista de cidades",
     *     tags={"Cidades"},
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="mensagem", type="string", example="Lista de cidades retornada"),
     *             @OA\Property(property="cidades", type="array", @OA\Items(ref="#/components/schemas/CidadeSchema"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $cidades = Cidade::all();

        return response()->json([
            'status' => 200,
            'mensagem' => 'Lista de cidades retornado',
            'cidades' => CidadeResource::collection($cidades)
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/cidade",
     *     summary="Criar uma nova cidade",
     *     tags={"Cidades"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CidadeRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="mensagem", type="string", example="Cidade criada"),
     *             @OA\Property(property="cidade", ref="#/components/schemas/CidadeSchema")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/cidade/{id}",
     *     summary="Obter os detalhes de uma cidade",
     *     tags={"Cidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/CidadeSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $cidade = Cidade::findOrFail($id);
            return new CidadeResource($cidade);
        } catch (ModelNotFoundException $e) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/cidade/{id}",
     *     summary="Atualizar uma cidade",
     *     tags={"Cidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CidadeRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="mensagem", type="string", example="Cidade atualizada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/cidade/{id}",
     *     summary="Deletar uma cidade",
     *     tags={"Cidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="mensagem", type="string", example="Deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado"
     *     )
     * )
     */
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePaisRequest;
use App\Http\Resources\PaisResource;
use App\Http\Resources\UserResource;
use App\Models\Pais;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/paises",
     *     summary="Obter lista de países",
     *     operationId="getPaises",
     *     tags={"Países"},
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PaisSchema"))
     *     )),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function index()
    {
        $pais = Pais::all();
        return PaisResource::collection($pais);
    }

    /**
     * @OA\Post(
     *     path="/paises",
     *     summary="Criar novo país",
     *     operationId="createPais",
     *     tags={"Países"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PaisRequestBody")
     *     ),
     *     @OA\Response(response="201", description="Criado com sucesso", @OA\JsonContent(
     *         @OA\Property(property="data", ref="#/components/schemas/PaisSchema")
     *     )),
     *     @OA\Response(response="400", description="Requisição inválida"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function store(StoreUpdatePaisRequest $request)
    {
        $data = $request->validated();
        $pais = Pais::create($data);

        return new PaisResource($pais);
    }

    /**
     * @OA\Get(
     *     path="/pais/{id}",
     *     summary="Obter informações de um país",
     *     operationId="getPais",
     *     tags={"Países"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do país",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="data", ref="#/components/schemas/PaisSchema")
     *     )),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function show(string $id)
    {
        try {
            $pais = Pais::findOrFail($id);
            return new PaisResource($pais);
        } catch (ModelNotFoundException $e) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/pais/{id}",
     *     summary="Atualizar informações de um país",
     *     operationId="updatePais",
     *     tags={"Países"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do país",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PaisRequestBody")
     *     ),
     *     @OA\Response(response="200", description="Sucesso", @OA\JsonContent(
     *         @OA\Property(property="data", ref="#/components/schemas/PaisSchema")
     *     )),
     *     @OA\Response(response="400", description="Requisição inválida"),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function update(StoreUpdatePaisRequest $request, string $id)
    {
        $pais = Pais::findOrfail($id);
        $data = $request->all();
        $pais->update($data);
        return new PaisResource($pais);
    }

    /**
     * @OA\Delete(
     *     path="/pais/{id}",
     *     summary="Excluir um país",
     *     operationId="deletePais",
     *     tags={"Países"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do país",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="204", description="Excluído com sucesso"),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function destroy(string $id)
    {
        $pais = Pais::findOrFail($id)->delete();
        return response()->json([], 204);
    }
}

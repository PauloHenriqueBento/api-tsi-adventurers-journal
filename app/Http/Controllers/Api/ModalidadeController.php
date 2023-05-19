<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateModalidadeRequest;
use App\Http\Resources\ModalidadeResource;
use App\Models\Modalidade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ModalidadeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/modalidade",
     *     summary="Lista de modalidades",
     *     description="Retorna a lista de modalidades.",
     *     operationId="index",
     *     tags={"Modalidades"},
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ModalidadeSchema")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $modalidades = Modalidade::all();
        $modalidades->each(function ($modalidade) {
            $modalidade->photo_path = $modalidade->photo_path ? asset('storage/' . $modalidade->photo_path) : null;
        });
        return ModalidadeResource::collection($modalidades);
    }

    /**
     * @OA\Post(
     *     path="/modalidade",
     *     summary="Criar modalidade",
     *     description="Cria uma nova modalidade.",
     *     operationId="store",
     *     tags={"Modalidades"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da modalidade",
     *         @OA\JsonContent(ref="#/components/schemas/ModalidadeRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/ModalidadeSchema")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"nome": {"O campo nome é obrigatório."}})
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateModalidadeRequest $request)
    {
        $data = $request->validated();
        $modalidades = Modalidade::create($data);

        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path');
            $photo_path = $photo->storePublicly('modalidade_photos', 'public');
            $modalidades->photo_path = $photo_path;
            $modalidades->save();
        }

        return new ModalidadeResource($modalidades);
    }

    /**
     * @OA\Get(
     *     path="/modalidade/{id}",
     *     summary="Detalhes da modalidade",
     *     description="Retorna os detalhes de uma modalidade.",
     *     operationId="show",
     *     tags={"Modalidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da modalidade",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/ModalidadeSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalidade não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="Status", type="string", example="Error"),
     *             @OA\Property(property="error", type="string", example="404")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $modalidades = Modalidade::findOrFail($id);
            $modalidades->photo_path = $modalidades->photo_path ? asset('storage/' . $modalidades->photo_path) : null;

            return new ModalidadeResource($modalidades);
        } catch (ModelNotFoundException) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/modalidade/{id}",
     *     summary="Atualizar modalidade",
     *     description="Atualiza uma modalidade existente.",
     *     operationId="update",
     *     tags={"Modalidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da modalidade",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da modalidade",
     *         @OA\JsonContent(ref="#/components/schemas/ModalidadeRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/ModalidadeSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalidade não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="Status", type="string", example="Error"),
     *             @OA\Property(property="error", type="string", example="404")
     *         )
     *     )
     * )
     */
    public function update(StoreUpdateModalidadeRequest $request, string $id)
    {
        $modalidades = Modalidade::findOrFail($id);
        $data = $request->all();
        $modalidades->update($data);
        return new ModalidadeResource($modalidades);
    }

    /**
     * @OA\Delete(
     *     path="/modalidade/{id}",
     *     summary="Deletar modalidade",
     *     description="Deleta uma modalidade existente.",
     *     operationId="destroy",
     *     tags={"Modalidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da modalidade",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalidade não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="Status", type="string", example="Error"),
     *             @OA\Property(property="error", type="string", example="404")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $modalidades = Modalidade::findOrFail($id)->delete();
        return response()->json([], 204);
    }
}

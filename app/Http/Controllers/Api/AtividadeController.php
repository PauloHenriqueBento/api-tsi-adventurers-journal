<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAtividadeRequest;
use App\Http\Requests\UpdateAtividadeRequest;
use App\Http\Resources\AtividadeResource;
use App\Models\Atividade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtividadeController extends Controller
{
    public function index()
    {
        $atividades = Atividade::all();

        if ($atividades->isEmpty()) {
            return response()->json(['message' => 'Sem atividades'], 200);
        }

        return AtividadeResource::collection($atividades);
    }

    public function store(StoreAtividadeRequest $request)
    {
        $this->authorize('create', Atividade::class);

        $usuarioId = Auth::id();

        $atividade = Atividade::create([
            'IdGuia' => $usuarioId,
            'preco' => $request->preco,
            'idCidade' => $request->idCidade,
            'Titulo' => $request->Titulo,
            'Descricao' => $request->Descricao,
            'DataTime' => $request->DataTime,
            'IdadeMinima' => $request->IdadeMinima,
        ]);

        return new AtividadeResource($atividade);
    }

    public function show(Atividade $atividade)
    {
        return new AtividadeResource($atividade);
    }

    public function update(UpdateAtividadeRequest $request, Atividade $atividade)
    {
        $this->authorize('update', $atividade);

        $data = $request->validated();

        $atividade->update($data);

        return new AtividadeResource($atividade);
    }

    public function delete(Atividade $atividade)
    {
        $this->authorize('delete', $atividade);

        try {
            // Remova qualquer referência à atividade em outras tabelas aqui
            // ...

            $atividade->delete();

            return response()->json(['message' => 'Atividade excluída com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir a atividade'], 500);
        }
    }

    // Lista as atividades criadas pelo usuario (Guia)
    public function listByUser()
    {
        $userId = Auth::id();

        $atividades = Atividade::where('IdGuia', $userId)->get();

        if ($atividades->isEmpty()) {
            return response()->json(['message' => 'Nenhuma atividade encontrada'], 200);
        }

        return AtividadeResource::collection($atividades);
    }
}

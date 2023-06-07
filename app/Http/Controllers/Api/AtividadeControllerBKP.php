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
        $usuarioId = Auth::id();

        $atividades = Atividade::where('idViajante', $usuarioId)->get();

        if ($atividades->isEmpty()) {
            return response()->json(['message' => 'Sem histórico de atividades'], 200);
        }

        return AtividadeResource::collection($atividades);
    }

    public function store(StoreAtividadeRequest $request)
    {
        $usuarioId = Auth::id();
        $idGuia = User::where('isGuia', true)->value('id');

        $atividade = Atividade::create([
            'idViajante' => $usuarioId,
            'idGuia' => $idGuia,
            'idCidade' => $request->idCidade,
            'idModalidade' => $request->idModalidade,
            'nota' => $request->nota,
            'comentario' => $request->comentario,
            'data' => $request->data,
        ]);

        return new AtividadeResource($atividade);
    }


    public function show(Atividade $atividade)
    {
        $this->authorize('view', $atividade);

        return new AtividadeResource($atividade);
    }

    public function update(UpdateAtividadeRequest $request, Atividade $atividade)
    {
        $this->authorize('update', $atividade);

        $atividade->update($request->only('comentario', 'nota'));

        return response()->json($atividade);
    }
}

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

        $modalidades = $request->input('Modalidades');
        $atividade->modalidades()->attach($modalidades);

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

        if ($request->has('Modalidades')) {
            $modalidades = $request->input('Modalidades');
            $atividade->modalidades()->sync($modalidades);
        }

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

    public function searchAtividades(Request $request)
    {
        $modalidades = $request->query('modalidades') ?? '';
        $modalidades = !empty($modalidades) ? explode(',', $modalidades) : [];
        $cidade = $request->query('cidade') ?? '';
        $horario = $request->query('horario') ?? '';
        $precoMinimo = $request->query('preco_minimo') ?? '';
        $precoMaximo = $request->query('preco_maximo') ?? '';
        $idadeMinima = $request->query('idade_minima') ?? '';

        $atividades = new Atividade;

        // Filtrar por modalidades
        if (!empty($modalidades)) {
            $atividades->whereHas('modalidades', function ($query) use ($modalidades) {
                $query->whereIn('modalidades.id', $modalidades);
            });
        }

        // Filtrar por horário
        if (!empty($horario)) {
            $atividades = $atividades->where('DataTime', $horario);
        }

        // Filtrar por cidade
        if (!empty($cidade)) {
            $atividades = $atividades->whereHas('cidade', function ($query) use ($cidade) {
                $query->where('nome', 'like', '%' . $cidade . '%');
            });
        }

        // Filtrar por preço mínimo e máximo
        if (!empty($precoMinimo) && !empty($precoMaximo)) {
            $atividades = $atividades->whereBetween('preco', [$precoMinimo, $precoMaximo]);
        } elseif (!empty($precoMinimo)) {
            // Filtrar apenas por preço mínimo
            $atividades = $atividades->where('preco', '>=', $precoMinimo);
        } elseif (!empty($precoMaximo)) {
            // Filtrar apenas por preço máximo
            $atividades = $atividades->where('preco', '<=', $precoMaximo);
        }

        // Filtrar por idade mínima
        if (!empty($idadeMinima)) {
            $atividades = $atividades->where('idadeMinima', '>=', $idadeMinima);
        };


        // dd($atividades);
        // dd(AtividadeResource::collection($atividades->get()));
        return AtividadeResource::collection($atividades->get());
    }
}

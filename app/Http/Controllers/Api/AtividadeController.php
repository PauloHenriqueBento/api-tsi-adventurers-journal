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
use Illuminate\Support\Facades\Storage;

class AtividadeController extends Controller
{
    public function index(Request $request)
    {
        $query = Atividade::query();

        // Filtro por modalidade
        if ($request->has('modalidade')) {
            $modalidade = $request->query('modalidade') ?? '';
            $modalidades = !empty($modalidade) ? explode(',', $modalidade) : [];
            $query->whereHas('modalidades', function ($query) use ($modalidades) {
                $query->whereIn('modalidade_id', $modalidades);
            }, '=', count($modalidades));
        }

        // Filtro por cidade
        if ($request->has('cidade')) {
            $cidade = $request->input('cidade');
            $query->whereHas('cidade', function ($q) use ($cidade) {
                $q->where('nome', 'like', '%' . $cidade . '%');
            });
        }

        // Filtro por dia
        if ($request->has('dia')) {
            $dia = $request->input('dia');
            $query->whereDate('DataTime', '>=', $dia)
                ->whereDate('DataTime', '>=', now()->format('Y-m-d'));
        }
        // else {
        //     // Se não for fornecido nenhum dia, filtra a partir do dia atual
        //     $query->whereDate('DataTime', '>=', now()->format('Y-m-d'));
        // }

        // Filtro por horário
        if ($request->has('horario')) {
            $horario = $request->input('horario');
            $query->whereTime('DataTime', '=', $horario);
        }

        // Filtro por preço mínimo
        if ($request->has('preco_min')) {
            $precoMin = $request->input('preco_min');
            $query->where('preco', '>=', $precoMin);
        }

        // Filtro por preço máximo
        if ($request->has('preco_max')) {
            $precoMax = $request->input('preco_max');
            $query->where('preco', '<=', $precoMax);
        }

        // Filtro por idade mínima
        if ($request->has('idade_min')) {
            $idadeMin = $request->input('idade_min');
            $query->where('IdadeMinima', '>=', $idadeMin);
        }

        // Filtro por ordem de preço (ascendente ou descendente)
        if ($request->has('ordenar_preco')) {
            $ordenarPreco = $request->input('ordenar_preco');
            $query->orderBy('preco', $ordenarPreco);
        }

        // Filtro por ordem de idade mínima (ascendente ou descendente)
        if ($request->has('ordenar_idade')) {
            $ordenarIdade = $request->input('ordenar_idade');
            $query->orderBy('IdadeMinima', $ordenarIdade);
        }

        // Filtro por ordem alfabética do título (ascendente ou descendente)
        if ($request->has('ordenar_titulo')) {
            $ordenarTitulo = $request->input('ordenar_titulo');
            $query->orderBy('Titulo', $ordenarTitulo);
        }


        $atividades = $query->get();
        // $totalResultados = $atividades->count();

        if ($atividades->isEmpty()) {
            return response()->json(['message' => 'Sem atividades'], 200);
        }

        $atividades->each(function ($atividade) {
            $atividade->photo_path = $atividade->photo_path ? asset('storage/' . $atividade->photo_path) : null;
        });

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

        if ($request->hasFile('photo_path')) {
            $profilePhoto = $request->file('photo_path');
            $profilePhotoPath = $profilePhoto->storePublicly('atividade_photos', 'public');
            $atividade->photo_path = $profilePhotoPath;
            $atividade->save();
        }

        return new AtividadeResource($atividade);
    }

    public function show(Atividade $atividade)
    {
        $atividade->photo_path = $atividade->photo_path ? asset('storage/' . $atividade->photo_path) : null;
        return new AtividadeResource($atividade);
    }

    public function update(UpdateAtividadeRequest $request, Atividade $atividade)
    {
        $this->authorize('update', $atividade);

        $data = $request->validated();

        // Verifica se uma nova imagem foi enviada
        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path');
            $photoPath = $photo->storePublicly('atividade_photos', 'public');

            // Remove a imagem antiga, se existir
            if ($atividade->photo_path) {
                Storage::disk('public')->delete($atividade->photo_path);
            }

            $data['photo_path'] = $photoPath;
        }

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

        $atividades->each(function ($atividade) {
            $atividade->photo_path = $atividade->photo_path ? asset('storage/' . $atividade->photo_path) : null;
        });

        return AtividadeResource::collection($atividades);
    }

    public function listByUserId($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $atividades = Atividade::where('IdGuia', $userId)->get();

        if ($atividades->isEmpty()) {
            return response()->json(['message' => 'Nenhuma atividade encontrada'], 200);
        }

        $atividades->each(function ($atividade) {
            $atividade->photo_path = $atividade->photo_path ? asset('storage/' . $atividade->photo_path) : null;
        });

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
        // if (!empty($modalidades)) {
        //     $atividades->whereHas('modalidades', function ($query) use ($modalidades) {
        //         $query->whereIn('modalidades.id', $modalidades);
        //     });
        // }

        // // Filtrar por horário
        // if (!empty($horario)) {
        //     $atividades = $atividades->where('DataTime', $horario);
        // }

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

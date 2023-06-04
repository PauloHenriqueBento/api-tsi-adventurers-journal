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
        // Obter os filtros do request
        $modalidades = $request->input('modalidades'); // Array de IDs das modalidades selecionadas
        $cidade = $request->input('cidade'); // Cidade a ser filtrada
        $horario = $request->input('horario'); // Horário a ser filtrado
        $precoMinimo = $request->input('preco_minimo'); // Preço mínimo a ser filtrado
        $precoMaximo = $request->input('preco_maximo'); // Preço máximo a ser filtrado

        // Consulta inicial
        $query = Atividade::query();

        // Verificar se a cidade foi especificada
        if ($cidade) {
            $query->whereHas('cidade', function ($query) use ($cidade) {
                $query->where('nome', 'like', '%' . $cidade . '%');
            });
        }

        // Verificar se as modalidades foram especificadas
        if ($modalidades && count($modalidades) > 0) {
            $query->whereHas('modalidades', function ($query) use ($modalidades) {
                $query->whereIn('id', $modalidades);
            });
        }

        // Verificar se o horário foi especificado
        if ($horario) {
            $query->where('DataTime', $horario);
        }

        // Verificar se o preço mínimo foi especificado
        if ($precoMinimo) {
            $query->where('preco', '>=', $precoMinimo);
        }

        // Verificar se o preço máximo foi especificado
        if ($precoMaximo) {
            $query->where('preco', '<=', $precoMaximo);
        }

        // Carregar relações
        $query->with('guia', 'cidade.estado.pais', 'modalidades');

        // Executar a consulta
        $atividades = $query->get();

        // Retornar os resultados
        return response()->json($atividades);
    }
}

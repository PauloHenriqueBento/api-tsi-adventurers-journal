<?php

namespace App\Http\Resources;

use App\Models\Atividade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItensPedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo_gerado,
            'idUsuario' => new UserResource(User::where('id', $this->idUsuario)->first()),
            'idAtividade' => AtividadeResource::collection(Atividade::where('id', $this->idAtividade)->get()),
            'status' => $this->status,
            'DatadoPedido' => $this->DatadoPedido,
            'TotalPedido' => $this->TotalPedido,
            'FormaPag' => $this->FormaPag,
            'qtdPessoa' => $this->qtdPessoa,
            "nota" => $this->nota,
            "comentario" => $this->comentario,
            'data' => $this->created_at,
        ];
    }
}

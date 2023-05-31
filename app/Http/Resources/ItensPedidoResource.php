<?php

namespace App\Http\Resources;

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
            'idUsuario' => $this->idUsuario,
            'idAtividade' => $this->idAtividade,
            'status' => $this->status,
            'DatadoPedido' => $this->DatadoPedido,
            'TotalPedido' => $this->TotalPedido,
            'FormaPag' => $this->FormaPag,
            'qtdPessoa' => $this->qtdPessoa
        ];
    }
}

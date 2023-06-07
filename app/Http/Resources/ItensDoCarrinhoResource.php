<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItensDoCarrinhoResource extends JsonResource
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
            //Linha abaixo da erro no retorno do JSON (Ainda não descoberto)
            'idAtividade' => new AtividadeResource($this->atividade),
            'Viajante' => $this->User,
            'qtdPessoa' => $this->qtdPessoa,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AtividadeResource extends JsonResource
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
            'guia' => [
                'id' => $this->IdGuia,
                'nome' => $this->guia->name,
                'email' => $this->guia->email,
            ],
            'cidade' => [
                'id' => $this->idCidade,
                'nome' => $this->cidade->nome,
            ],
            'Preço' => $this->Preco,
            'Titulo' => $this->Titulo,
            'Descrição' => $this->Descricao,
            'Data e Hora' => $this->DataTime,
            'Idade minima' => $this->IdadeMinima
        ];
    }
}

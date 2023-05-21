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
            'viajante' => [
                'id' => $this->idViajante,
                'nome' => $this->viajante->name,
                'email' => $this->viajante->email,
                // outras informações relevantes do viajante
            ],
            'guia' => [
                'id' => $this->idGuia,
                'nome' => $this->guia->name,
                'email' => $this->guia->email,
                // outras informações relevantes do guia
            ],
            'modalidade' => [
                'id' => $this->idModalidade,
                'nome' => $this->modalidade->nome,
                // outras informações relevantes da modalidade
            ],
            'cidade' => [
                'id' => $this->idCidade,
                'nome' => $this->cidade->nome,
            ],
            'nota' => $this->nota,
            'comentario' => $this->comentario,
            'data' => $this->data
        ];
    }
}

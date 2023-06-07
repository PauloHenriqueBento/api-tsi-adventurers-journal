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
                'bio' => $this->guia->bio,
                'foto' => $this->guia->profile_photo_path,
            ],
            'cidade' => [
                'id' => $this->idCidade,
                'nome' => $this->cidade->nome,
                'uf' => $this->cidade->estado->uf,
                'pais' => $this->cidade->estado->pais->nome
            ],
            'preco' => $this->preco,
            'Titulo' => $this->Titulo,
            'Descrição' => $this->Descricao,
            'Data_e_Hora' => $this->DataTime,
            'Idade minima' => $this->IdadeMinima,
            'modalidade' => ModalidadeResource::collection($this->modalidades),
            'foto_url' => $this->photo_path
        ];
    }
}

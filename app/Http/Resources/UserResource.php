<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $photoUrl = asset('storage/' . $this->profile_photo_path);
        $bannerUrl = asset('storage/' . $this->profile_banner_path);
        return [
            'identify' => $this->id,
            'name'  => $this->name,
            // 'name'  => strtoupper($this->name),
            'data_nascimento' => $this->data_nascimento,
            'email' => $this->email,
            'cidade' => $this->id_cidade,
            'foto_URL' => $this->profile_photo_path,
            'banner_URL' => $this->profile_banner_path,
            'modalidade' => ModalidadeResource::collection($this->modalidades),
            'bio' => $this->bio,
            'Guia' => $this->isGuia,
            'Assinatura' => new AssinaturaResource($this->assinatura),
        ];
    }
}

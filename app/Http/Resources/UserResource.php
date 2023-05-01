<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $this->id,
            'name'  =>strtoupper ($this->name),
            'data nascimento' => $this->data_nascimento,
            'email' => $this->email,
            'cidade' => $this->id_cidade,
            'foto URL' => $this->profile_photo_path,
            'banner URL' => $this->profile_banner_path,
            'modalidade' => $this->modalidade,
            'telefone' => $this->telefone,
            'facebook' => $this->facebook_url,
            'instagram' => $this->instagram_url,
            'twitter' => $this->twitter_url,
            'bio' => $this->bio,
            'Guia' => $this->isGuia,
            'created' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}

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
            'name'  => strtoupper($this->name),
            'data_nascimento' => $this->data_nascimento,
            'email' => $this->email,
            'cidade' => $this->id_cidade,
            'foto_URL' => $this->profile_photo_path,
            'banner_URL' => $this->profile_banner_path,
            // 'foto_URL' => $photoBase64 ?? ,
            // 'banner_URL' => $bannerBase64 ?? ,
            'modalidade' => ModalidadeResource::collection($this->modalidades),
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

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
        $photoBase64 = "";
        $bannerBase64 = "";
        if ($this->base64) {
            $photoPath = storage_path('app/profile_photos/' . $this->profile_photo_path);
            $bannerPath = storage_path('app/profile_banner/' . $this->profile_banner_path);

            if (file_exists($photoPath)) {
                $photoContent = file_get_contents($photoPath);
                $photoBase64 = base64_encode($photoContent);
            }
            if (file_exists($bannerPath)) {
                $bannerContent = file_get_contents($bannerPath);
                $bannerBase64 = base64_encode($bannerContent);
            }
        }

        return [
            'identify' => $this->id,
            'name'  => strtoupper($this->name),
            'data_nascimento' => $this->data_nascimento,
            'email' => $this->email,
            'cidade' => $this->id_cidade,
            'foto_URL' => empty($photoBase64) ? $this->profile_photo_path : $photoBase64,
            'banner_URL' => empty($bannerBase64) ? $this->profile_banner_path : $bannerBase64,
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

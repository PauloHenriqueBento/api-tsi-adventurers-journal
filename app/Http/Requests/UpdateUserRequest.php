<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'name' => 'sometimes|min:3|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                "unique:users,email,{$this->id},id"
            ],
            'password' => [
                'nullable',
                'min:6',
                'max:100',
            ],
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'id_cidade' => 'nullable|integer',
            /* 'profile_photo_path' => 'nullable|image|max:2048',
                'profile_banner_path' => 'nullable|image|max:2048',*/
            'profile_photo_path' => 'nullable|file|mimes:jpeg,jpg,png|max:4096', //4 MB em bytes
            'profile_banner_path' => 'nullable|file|mimes:jpeg,jpg,png|max:4096',
            'modalidade' => 'nullable|array|min:1',
            'telefone' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'bio' => 'nullable|string',
        ];

        return $rules;
    }
}

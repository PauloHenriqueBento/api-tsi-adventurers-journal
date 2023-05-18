<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateUserRequest extends FormRequest
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

        // Regra de validação na hora de Criar/Editar
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'min:6',
                'max:100'
            ],
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'id_cidade' => 'nullable|integer',
            /* 'profile_photo_path' => 'nullable|string|max:4194304', //4 MB em bytes
            'profile_banner_path' => 'nullable|string|max:4194304', //4 MB em bytes*/
            'profile_photo_path' => 'nullable|file|mimes:jpeg,jpg,png|max:4096',
            'profile_banner_path' => 'nullable|file|mimes:jpeg,jpg,png|max:4096',
            'modalidade' => 'nullable|array|min:1',
            'telefone' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'bio' => 'nullable|string'
        ];

        //Valida se é atualização, se for, usuario não precisa remandar alguns campos

        if ($this->method() == "PATCH" || $this->method() == "PUT") {
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
        }



        return $rules;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(([
            'message' => 'Erro de validação',
            'errors' => $validator->errors()
        ]), 422));
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            ]
        ];

        //Valida se é atualização, se for, usuario não precisa remandar alguns campos

        if ($this->method() === "PATCH") {
            $rules['password'] = [
                'nullable',
                'min:6',
                'max:100'
            ];

            $rules['email'] = [
                'required',
                'email',
                'max:255',
                //Deixa o email unico, mas se for o já existente do proprio user não faça nada
                "unique:users,email,{$this->id},id"
            ];
        }

        return $rules;
    }
}

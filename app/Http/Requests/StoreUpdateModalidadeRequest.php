<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateModalidadeRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nome' => "required|unique:modalidades,nome,{$this->id},id",
            'descricao' => 'nullable|string',
            'photo_path' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.unique' => 'Já existe uma modalidade com este nome.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'photo_path.string' => 'O campo photo_path deve ser uma string.'
        ];
    }
}

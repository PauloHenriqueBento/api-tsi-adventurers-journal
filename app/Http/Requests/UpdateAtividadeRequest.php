<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAtividadeRequest extends FormRequest
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
        return [
            'preco' => 'nullable|numeric',
            'idCidade' => 'nullable|exists:cidade,id',
            'Titulo' => 'nullable|string',
            'Descricao' => 'nullable|string',
            'DataTime' => 'nullable|date',
            'IdadeMinima' => 'nullable|integer',
        ];
    }
}

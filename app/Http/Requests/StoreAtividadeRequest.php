<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtividadeRequest extends FormRequest
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
            'preco' => 'required|numeric',
            'idCidade' => 'required|exists:cidade,id',
            'Titulo' => 'required|string',
            'Descricao' => 'required|string',
            'DataTime' => 'required|date',
            'IdadeMinima' => 'nullable|integer',
        ];
    }
}

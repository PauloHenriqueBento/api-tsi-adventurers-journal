<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssinaturaRequest extends FormRequest
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
            "nome" => "required|min:3|max:255",
            "preco" => "required|string"
        ];

        if($this->method() == "PATCH" || $this->method() == "PUT") {
            $rules = [
                "nome" => "sometimes|min:3|max:255",
                "preco" => "nullable|string",
            ];
        }

        return $rules;
    }
}

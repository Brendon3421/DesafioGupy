<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'errors' => $validator->errors()
            ],
            422
        ));
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:5',
            'situacao_id' => 'nullable|exists:situacao,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => "O campo título é obrigatório.",
            'description.required' => "O campo descrição é obrigatório.",
            'description.min' => "Escreva no mínimo 5 letras.",
            'situacao_id.exists' => "A situação não existe.",
        ];
    }
}

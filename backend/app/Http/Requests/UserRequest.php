<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
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
        $userID = $this->route('user');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($userID ? $userID->id : 'NULL'),
            'password' => $userID ? 'nullable|min:6' : 'required|min:6', // senha não é obrigatória na atualização
            'genero_id' => 'required|exists:genero,id',
            'situacao_id' => 'exists:situacao,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "O campo nome é obrigatório.",
            'email.required' => "O campo email é obrigatório.",
            'email.email' => "O campo deve ser um e-mail válido.",
            'email.unique' => "Email já está em uso.",
            'password.required' => "Senha é obrigatória.",
            'password.min' => "O mínimo é 6 caracteres.",
            'genero_id.required' => "O campo de genero é obrigatório.",
            'genero_id.exists' => "O gênero selecionado não existe.",
            'situacao_id.exists' => "A situação selecionada não existe.",
            'empresa_id.exists' => "A Empresa selecionada não existe."
        ];
    }
}

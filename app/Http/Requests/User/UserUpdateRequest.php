<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:60',
            'email' => 'sometimes|string|email|max:255|unique:users,email',
            'password' => 'sometimes|string|min:6|confirmed',
            'telephone' => 'sometimes|string|max:20',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.sometimes'     => 'O campo nome é opcional, mas se fornecido deve ser válido.',
            'name.string'        => 'O campo nome deve ser uma string.',
            'name.max'           => 'O nome não pode ter mais que 60 caracteres.',

            'email.sometimes'    => 'O campo email é opcional, mas se fornecido deve ser válido.',
            'email.string'       => 'O campo email deve ser uma string.',
            'email.email'        => 'O campo email deve ser um email válido, exemplo: myaccount@gmail.com.',
            'email.max'          => 'O email não pode ter mais que 255 caracteres.',
            'email.unique'       => 'O email fornecido já está em uso.',

            'password.sometimes' => 'O campo senha é opcional, mas se fornecido deve ser válido.',
            'password.string'    => 'O campo senha deve ser uma string.',
            'password.min'       => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',

            'telephone.sometimes' => 'O campo telefone é opcional, mas se fornecido deve ser válido.',
            'telephone.string'    => 'O campo telefone deve ser uma string.',
            'telephone.max'       => 'O telefone não pode ter mais que 20 caracteres.',
        ];
    }
}

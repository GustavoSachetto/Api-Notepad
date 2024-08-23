<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
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
            'title' => 'required|max:70',
            'content' => 'required|max:255',
            'category' => 'required|max:255',
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
            'title.required'   => 'O campo título é obrigatório.',
            'title.max'        => 'O título não pode ter mais que 70 caracteres.',

            'content.required' => 'O campo conteúdo é obrigatório.',
            'content.max'      => 'O conteúdo não pode ter mais que 255 caracteres.',

            'category.required' => 'O campo categoria é obrigatório.',
            'category.max'      => 'A categoria não pode ter mais que 255 caracteres.',
        ];
    }
}

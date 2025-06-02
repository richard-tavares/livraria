<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'description' => 'descrição',
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo descrição é obrigatório.',
            'description.max' => 'A descrição não pode ter mais que :max caracteres.',
        ];
    }
}

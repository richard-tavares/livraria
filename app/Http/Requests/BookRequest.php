<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:40'],
            'edition' => ['required', 'integer', 'min:1'],
            'publication_year' => ['required', 'digits:4'],
            'price' => ['required', 'numeric', 'min:0'],
            'authors' => ['required', 'array', 'min:1'],
            'authors.*' => ['exists:authors,id'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*' => ['exists:subjects,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'título',
            'publisher' => 'editora',
            'edition' => 'edição',
            'publication_year' => 'ano de publicação',
            'price' => 'preço',
            'authors' => 'autores',
            'subjects' => 'assuntos',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.max' => 'O título não pode ter mais que :max caracteres.',
            'publisher.required' => 'O campo editora é obrigatório.',
            'publisher.max' => 'A editora não pode ter mais que :max caracteres.',
            'edition.required' => 'O campo edição é obrigatório.',
            'edition.integer' => 'A edição deve ser um número inteiro.',
            'edition.min' => 'A edição deve ser no mínimo 1.',
            'publication_year.required' => 'O campo ano de publicação é obrigatório.',
            'publication_year.digits' => 'O ano de publicação deve ter exatamente :digits dígitos.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            'authors.required' => 'Selecione pelo menos um autor.',
            'authors.array' => 'Os autores devem ser enviados em formato de lista.',
            'authors.*.exists' => 'Um ou mais autores selecionados são inválidos.',
            'subjects.required' => 'Selecione pelo menos um assunto.',
            'subjects.array' => 'Os assuntos devem ser enviados em formato de lista.',
            'subjects.*.exists' => 'Um ou mais assuntos selecionados são inválidos.',
        ];
    }
}

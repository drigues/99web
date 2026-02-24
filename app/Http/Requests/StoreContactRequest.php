<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'      => ['required', 'string', 'min:2', 'max:120'],
            'email'     => ['required', 'email:rfc,dns', 'max:180'],
            'telefone'  => ['nullable', 'string', 'max:30'],
            'empresa'   => ['nullable', 'string', 'max:120'],
            'website'   => ['nullable', 'url', 'max:250'],
            'mensagem'  => ['required', 'string', 'min:10', 'max:2000'],
            'source'    => ['nullable', 'string', 'max:60'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'     => 'O nome é obrigatório.',
            'nome.min'          => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required'    => 'O email é obrigatório.',
            'email.email'       => 'Introduza um email válido.',
            'website.url'       => 'Introduza um URL válido (ex: https://www.exemplo.pt).',
            'mensagem.required' => 'A mensagem é obrigatória.',
            'mensagem.min'      => 'A mensagem deve ter pelo menos 10 caracteres.',
            'mensagem.max'      => 'A mensagem não pode exceder 2000 caracteres.',
        ];
    }
}

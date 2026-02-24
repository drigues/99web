<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nome'            => ['required', 'string', 'min:2', 'max:120'],
            'email'           => ['required', 'email:rfc,dns', 'max:180'],
            'telefone'        => ['required', 'string', 'max:30'],
            'empresa'         => ['required', 'string', 'max:120'],
            'descricao'       => ['required', 'string', 'min:10', 'max:3000'],
            'tem_dominio'     => ['boolean'],
            'tem_alojamento'  => ['boolean'],
            'website_atual'   => ['nullable', 'url', 'max:250'],
            'prazo'           => ['required', 'in:1_semana,2_semanas,1_mes,sem_urgencia'],
            'aceita_termos'   => ['accepted'],
        ];

        if ($this->route('type') === 'personalizado') {
            $rules['orcamento'] = ['required', 'string', 'max:60'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nome.required'          => 'O nome é obrigatório.',
            'nome.min'               => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required'         => 'O email é obrigatório.',
            'email.email'            => 'Introduza um email válido.',
            'telefone.required'      => 'O telefone é obrigatório.',
            'empresa.required'       => 'A empresa é obrigatória.',
            'descricao.required'     => 'A descrição do projeto é obrigatória.',
            'descricao.min'          => 'A descrição deve ter pelo menos 10 caracteres.',
            'website_atual.url'      => 'Introduza um URL válido.',
            'prazo.required'         => 'Selecione um prazo.',
            'prazo.in'               => 'Prazo inválido.',
            'aceita_termos.accepted' => 'Deve aceitar os Termos e Condições para continuar.',
            'orcamento.required'     => 'Indique o orçamento estimado.',
        ];
    }
}

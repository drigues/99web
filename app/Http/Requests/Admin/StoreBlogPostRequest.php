<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['required', 'string', 'max:255', 'unique:blog_posts,slug'],
            'excerpt'          => ['required', 'string', 'max:300'],
            'content'          => ['required', 'string'],
            'category_id'      => ['required', 'exists:blog_categories,id'],
            'author_id'        => ['required', 'exists:admin_users,id'],
            'featured_image'   => ['nullable', 'string', 'max:500'],
            'og_image'         => ['nullable', 'string', 'max:500'],
            'meta_title'       => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords'    => ['nullable', 'string', 'max:255'],
            'canonical_url'    => ['nullable', 'url', 'max:500'],
            'is_published'     => ['boolean'],
            'published_at'     => ['nullable', 'date'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['exists:blog_tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'O título é obrigatório.',
            'slug.required'        => 'O slug é obrigatório.',
            'slug.unique'          => 'Este slug já está em uso.',
            'excerpt.required'     => 'O excerto é obrigatório.',
            'excerpt.max'          => 'O excerto não pode ter mais de 300 caracteres.',
            'content.required'     => 'O conteúdo é obrigatório.',
            'category_id.required' => 'Selecione uma categoria.',
            'category_id.exists'   => 'A categoria selecionada não existe.',
            'author_id.required'   => 'Selecione um autor.',
            'canonical_url.url'    => 'A URL canónica deve ser uma URL válida.',
        ];
    }
}

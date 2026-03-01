<div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
    <p class="text-xs text-gray-500 mb-1">Preview nos resultados Google:</p>
    <div class="space-y-1">
        <p class="text-blue-600 dark:text-blue-400 text-lg font-medium leading-tight truncate">
            {{ $getRecord()?->meta_title ?: $getRecord()?->title ?: 'Título do artigo' }} — 99web
        </p>
        <p class="text-green-700 dark:text-green-500 text-sm">
            {{ config('app.url') }}/blog/{{ $getRecord()?->slug ?: 'url-do-artigo' }}
        </p>
        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
            {{ $getRecord()?->meta_description ?: Str::limit($getRecord()?->excerpt ?? 'Descrição do artigo aparece aqui...', 155) }}
        </p>
    </div>
</div>

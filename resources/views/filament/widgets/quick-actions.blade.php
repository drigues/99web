<x-filament-widgets::widget>
    <x-filament::section heading="Ações Rápidas">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ $this->getNewPostUrl() }}"
               class="flex items-center gap-3 p-4 rounded-xl bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20 hover:bg-primary-100 dark:hover:bg-primary-500/20 transition-colors">
                <x-heroicon-o-plus-circle class="w-6 h-6 text-primary-500" />
                <span class="font-medium text-primary-700 dark:text-primary-400">Novo Post</span>
            </a>

            <a href="/" target="_blank"
               class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                <x-heroicon-o-globe-alt class="w-6 h-6 text-gray-500 dark:text-gray-400" />
                <span class="font-medium text-gray-700 dark:text-gray-300">Ver Site</span>
            </a>

            <button wire:click="clearCache" type="button"
                    class="flex items-center gap-3 p-4 rounded-xl bg-warning-50 dark:bg-warning-500/10 border border-warning-200 dark:border-warning-500/20 hover:bg-warning-100 dark:hover:bg-warning-500/20 transition-colors text-left">
                <x-heroicon-o-arrow-path class="w-6 h-6 text-warning-500" />
                <span class="font-medium text-warning-700 dark:text-warning-400">Limpar Cache</span>
            </button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

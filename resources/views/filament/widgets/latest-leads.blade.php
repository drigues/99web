<x-filament-widgets::widget>
    <x-filament::section heading="Últimos Contactos & Pedidos">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-white/10">
                        <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Tipo</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Nome</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Data</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-2 text-right font-medium text-gray-500 dark:text-gray-400"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->getLeads() as $lead)
                        <tr class="border-b border-gray-100 dark:border-white/5">
                            <td class="px-4 py-3">
                                <x-filament::badge :color="$lead['type_color']">
                                    {{ $lead['type'] }}
                                </x-filament::badge>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $lead['name'] }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $lead['email'] }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $lead['date']->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <x-filament::badge :color="match($lead['status']) {
                                    'novo' => 'warning',
                                    'pendente' => 'warning',
                                    'respondido', 'confirmada' => 'success',
                                    'contactado' => 'info',
                                    'cancelada' => 'danger',
                                    default => 'gray',
                                }">
                                    {{ ucfirst($lead['status']) }}
                                </x-filament::badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ $lead['url'] }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium">
                                    Ver &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhum lead recente
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

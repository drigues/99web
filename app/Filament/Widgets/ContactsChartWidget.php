<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ContactsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Contactos (últimos 30 dias)';
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $data = collect(range(29, 0))->map(function (int $daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'date'  => $date->format('d/m'),
                'count' => Contact::whereDate('created_at', $date)->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Contactos',
                    'data'  => $data->pluck('count')->toArray(),
                    'borderColor' => '#7c3aed',
                    'backgroundColor' => 'rgba(124, 58, 237, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

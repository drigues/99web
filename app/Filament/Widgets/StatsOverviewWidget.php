<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\MeetingRequest;
use App\Models\PackageRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Contactos Novos', Contact::where('status', 'novo')->count())
                ->description('Aguardam resposta')
                ->color('warning')
                ->icon('heroicon-o-envelope'),

            Stat::make('Pedidos Pendentes', PackageRequest::where('status', 'novo')->count())
                ->description('Novos pedidos de pacotes')
                ->color('danger')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Reuniões Pendentes', MeetingRequest::where('status', 'pendente')->count())
                ->description('Aguardam confirmação')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Posts Publicados', BlogPost::where('is_published', true)->count())
                ->description('Total de posts no blog')
                ->color('success')
                ->icon('heroicon-o-document-text'),
        ];
    }
}

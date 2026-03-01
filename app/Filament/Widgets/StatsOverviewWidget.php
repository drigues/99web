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
        $contactsNow = Contact::where('status', 'novo')->count();
        $contactsThisMonth = Contact::where('status', 'novo')
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        $contactsLastMonth = Contact::where('status', 'novo')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->count();

        $variation = $contactsLastMonth > 0
            ? round((($contactsThisMonth - $contactsLastMonth) / $contactsLastMonth) * 100)
            : ($contactsThisMonth > 0 ? 100 : 0);

        return [
            Stat::make('Contactos Novos', $contactsNow)
                ->description(($variation >= 0 ? '+' : '') . $variation . '% vs mês anterior')
                ->descriptionIcon($variation >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('primary')
                ->icon('heroicon-o-envelope'),

            Stat::make('Pedidos Pendentes', PackageRequest::whereIn('status', ['novo', 'contactado'])->count())
                ->description('Novos e contactados')
                ->color('info')
                ->icon('heroicon-o-shopping-bag'),

            Stat::make('Reuniões Esta Semana', MeetingRequest::where('status', 'pendente')
                ->whereBetween('preferred_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count())
                ->description('Aguardam confirmação')
                ->color('success')
                ->icon('heroicon-o-calendar'),

            Stat::make('Visitas Blog (30d)', number_format(
                BlogPost::where('updated_at', '>=', now()->subDays(30))->sum('views_count')
            ))
                ->description('Visualizações nos últimos 30 dias')
                ->color('warning')
                ->icon('heroicon-o-eye'),
        ];
    }
}

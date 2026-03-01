<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactResource;
use App\Filament\Resources\MeetingRequestResource;
use App\Filament\Resources\PackageRequestResource;
use App\Models\Contact;
use App\Models\MeetingRequest;
use App\Models\PackageRequest;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class LatestLeadsWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-leads';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function getLeads(): Collection
    {
        $contacts = Contact::latest()->take(5)->get()->map(fn ($c) => [
            'type' => 'Contacto',
            'type_color' => 'primary',
            'name' => $c->name,
            'email' => $c->email,
            'date' => $c->created_at,
            'status' => $c->status,
            'url' => ContactResource::getUrl('view', ['record' => $c]),
        ]);

        $packages = PackageRequest::latest()->take(5)->get()->map(fn ($p) => [
            'type' => 'Pacote',
            'type_color' => 'info',
            'name' => $p->name,
            'email' => $p->email,
            'date' => $p->created_at,
            'status' => $p->status,
            'url' => PackageRequestResource::getUrl('view', ['record' => $p]),
        ]);

        $meetings = MeetingRequest::latest()->take(5)->get()->map(fn ($m) => [
            'type' => 'Reunião',
            'type_color' => 'success',
            'name' => $m->name,
            'email' => $m->email,
            'date' => $m->created_at,
            'status' => $m->status,
            'url' => MeetingRequestResource::getUrl('view', ['record' => $m]),
        ]);

        return $contacts->concat($packages)->concat($meetings)
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }
}

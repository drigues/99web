<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\MeetingRequest;
use App\Models\PackageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ── Estatísticas ─────────────────────────────────────────
        $stats = [
            'contacts'         => Contact::count(),
            'contacts_novos'   => Contact::novo()->count(),
            'package_requests' => PackageRequest::count(),
            'package_novos'    => PackageRequest::novo()->count(),
            'meetings'         => MeetingRequest::count(),
            'meetings_pending' => MeetingRequest::pendente()->count(),
            'blog_posts'       => BlogPost::count(),
            'blog_published'   => BlogPost::published()->count(),
        ];

        // ── Atividade combinada (10 mais recentes) ────────────────
        $contacts = Contact::latest()->limit(10)->get()->map(fn ($c) => [
            'type'     => 'contact',
            'label'    => 'Contacto',
            'sublabel' => null,
            'name'     => $c->name,
            'email'    => $c->email,
            'date'     => $c->created_at,
            'status'   => $c->status,
            'id'       => $c->id,
            'href'     => '/admin/contactos/' . $c->id,
        ]);

        $packages = PackageRequest::latest()->limit(10)->get()->map(fn ($p) => [
            'type'     => 'package',
            'label'    => 'Pacote',
            'sublabel' => ucfirst($p->package_type),
            'name'     => $p->name,
            'email'    => $p->email,
            'date'     => $p->created_at,
            'status'   => $p->status,
            'id'       => $p->id,
            'href'     => '/admin/pedidos/' . $p->id,
        ]);

        $meetings = MeetingRequest::latest()->limit(10)->get()->map(fn ($m) => [
            'type'     => 'meeting',
            'label'    => 'Reunião',
            'sublabel' => null,
            'name'     => $m->name,
            'email'    => $m->email,
            'date'     => $m->created_at,
            'status'   => $m->status,
            'id'       => $m->id,
            'href'     => '/admin/reunioes/' . $m->id,
        ]);

        $recent_activity = $contacts
            ->concat($packages)
            ->concat($meetings)
            ->sortByDesc('date')
            ->take(10)
            ->values();

        // ── Dados do gráfico (contactos por dia, últimos 30 dias) ─
        $contactsByDay = Contact::where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $chart_labels = [];
        $chart_values = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chart_labels[] = $date->format('d/m');
            $chart_values[] = (int) $contactsByDay->get($date->format('Y-m-d'), 0);
        }

        return view('admin.dashboard', compact(
            'stats',
            'recent_activity',
            'chart_labels',
            'chart_values',
        ));
    }

    public function notificationsCount(): JsonResponse
    {
        $count = Contact::novo()->count()
               + PackageRequest::novo()->count()
               + MeetingRequest::pendente()->count();

        return response()->json(['count' => $count]);
    }
}

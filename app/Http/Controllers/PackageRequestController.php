<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequestRequest;
use App\Mail\PackageRequestConfirmation;
use App\Mail\PackageRequestNotification;
use App\Models\PackageRequest;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class PackageRequestController extends Controller
{
    public function show(string $type): View
    {
        $packages = config('packages');

        abort_if(!isset($packages[$type]), 404);

        SEOMeta::setTitle('Pacote ' . $packages[$type]['name'] . ' — 99web');
        SEOMeta::setDescription('Solicite o pacote ' . $packages[$type]['name'] . ' da 99web. Websites profissionais para o seu negócio.');

        return view('packages.request', [
            'package' => $packages[$type],
            'type'    => $type,
        ]);
    }

    public function store(string $type, StorePackageRequestRequest $request): RedirectResponse
    {
        // Honeypot anti-spam: se campo _hp vier preenchido, é bot
        if ($request->filled('_hp')) {
            return redirect()->route('pacotes.obrigado');
        }

        $packages = config('packages');

        abort_if(!isset($packages[$type]), 404);

        $deadlineMap = [
            '1_semana'    => now()->addDays(7),
            '2_semanas'   => now()->addDays(14),
            '1_mes'       => now()->addDays(30),
            'sem_urgencia' => null,
        ];

        $packageRequest = PackageRequest::create([
            'name'                => $request->nome,
            'email'               => $request->email,
            'phone'               => $request->telefone,
            'company'             => $request->empresa,
            'package_type'        => $type,
            'budget'              => $request->orcamento,
            'project_description' => $request->descricao,
            'has_domain'          => $request->boolean('tem_dominio'),
            'has_hosting'         => $request->boolean('tem_alojamento'),
            'current_website'     => $request->website_atual,
            'deadline'            => $deadlineMap[$request->prazo] ?? null,
            'status'              => 'novo',
        ]);

        try {
            Mail::to($request->email)
                ->send(new PackageRequestConfirmation($packageRequest, $packages[$type]));

            Mail::to(config('mail.admin_address', 'geral@99web.pt'))
                ->send(new PackageRequestNotification($packageRequest, $packages[$type]));
        } catch (\Throwable) {
            // Não falha o redirect se o mail falhar
        }

        return redirect()->route('pacotes.obrigado');
    }

    public function obrigado(): View
    {
        SEOMeta::setTitle('Pedido recebido — 99web');
        SEOMeta::setDescription('O seu pedido foi recebido com sucesso. A equipa 99web irá entrar em contacto em breve.');

        return view('packages.obrigado');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\NewContactNotification;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        // Honeypot anti-spam: silently discard if _hp field is filled by a bot
        if ($request->filled('_hp')) {
            return response()->json(['message' => 'Contacto recebido com sucesso.'], 201);
        }

        $contact = Contact::create([
            'name'        => $request->nome,
            'email'       => $request->email,
            'phone'       => $request->telefone,
            'company'     => $request->empresa,
            'website_url' => $request->website,
            'message'     => $request->mensagem,
            'source'      => $request->source ?? 'website',
            'status'      => 'new',
        ]);

        try {
            Mail::to(config('mail.admin_address', 'geral@99web.pt'))
                ->send(new NewContactNotification($contact));
        } catch (\Throwable) {
            // Não falha o request se o mail falhar
        }

        return response()->json([
            'message' => 'Contacto recebido com sucesso.',
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactController extends Controller
{
    private const STATUSES = ['novo', 'em_analise', 'respondido', 'fechado'];

    public function index(Request $request): View
    {
        $query = Contact::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($source = $request->input('source')) {
            $query->where('source', $source);
        }

        $contacts = $query->paginate(15)->withQueryString();

        $sources = Contact::distinct()->pluck('source')->filter()->sort()->values();

        return view('admin.contactos.index', compact('contacts', 'sources'));
    }

    public function show(Contact $contact): View
    {
        return view('admin.contactos.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
        ]);

        $contact->status = $request->status;

        if ($request->status === 'respondido' && !$contact->responded_at) {
            $contact->responded_at = now();
        }

        $contact->save();

        return back()->with('success', 'Estado atualizado para "' . $request->status . '".');
    }

    public function updateNotes(Request $request, Contact $contact): JsonResponse
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:5000']]);

        $contact->update(['notes' => $request->notes]);

        return response()->json(['ok' => true]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contactos.index')
            ->with('success', 'Contacto eliminado.');
    }
}

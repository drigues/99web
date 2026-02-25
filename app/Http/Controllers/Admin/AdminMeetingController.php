<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MeetingConfirmation;
use App\Models\ActivityLog;
use App\Models\MeetingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMeetingController extends Controller
{
    private const STATUSES = ['pendente', 'confirmado', 'cancelado'];

    public function index(Request $request): View
    {
        $query = MeetingRequest::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->input('meeting_type')) {
            $query->where('meeting_type', $type);
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('preferred_date', '>=', $dateFrom);
        }

        $reunioes = $query->paginate(15)->withQueryString();

        $today   = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        return view('admin.reunioes.index', compact('reunioes', 'today', 'tomorrow'));
    }

    public function show(MeetingRequest $reuniao): View
    {
        return view('admin.reunioes.show', compact('reuniao'));
    }

    public function updateStatus(Request $request, MeetingRequest $reuniao): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
        ]);

        $reuniao->update(['status' => $request->status]);

        return back()->with('success', 'Estado atualizado para "' . $request->status . '".');
    }

    public function confirm(Request $request, MeetingRequest $reuniao): RedirectResponse
    {
        $request->validate([
            'confirmed_date' => ['required', 'date', 'after_or_equal:today'],
            'confirmed_time' => ['required', 'string', 'regex:/^\d{2}:\d{2}$/'],
        ], [
            'confirmed_date.required'        => 'A data confirmada é obrigatória.',
            'confirmed_date.after_or_equal'  => 'A data confirmada não pode ser no passado.',
            'confirmed_time.required'        => 'A hora confirmada é obrigatória.',
        ]);

        $reuniao->confirm($request->confirmed_date, $request->confirmed_time);

        try {
            Mail::to($reuniao->email)->send(new MeetingConfirmation($reuniao));
        } catch (\Throwable) {
            // Não falha a ação se o mail falhar
        }

        return back()->with('success', 'Reunião confirmada. Email enviado ao cliente.');
    }

    public function updateNotes(Request $request, MeetingRequest $reuniao): JsonResponse
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:5000']]);

        $reuniao->update(['admin_notes' => $request->notes]);

        return response()->json(['ok' => true]);
    }

    public function destroy(MeetingRequest $reuniao): RedirectResponse
    {
        ActivityLog::record('deleted', $reuniao, "Reunião eliminada: {$reuniao->name}");
        $reuniao->delete();

        return redirect()->route('admin.reunioes.index')
            ->with('success', 'Reunião eliminada.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = MeetingRequest::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($type = $request->input('meeting_type')) {
            $query->where('meeting_type', $type);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('preferred_date', '>=', $dateFrom);
        }

        $reunioes = $query->get();

        ActivityLog::record('export', null, "Exportação CSV de {$reunioes->count()} reuniões");

        $filename = 'reunioes_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($reunioes) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['Nome', 'Email', 'Tipo', 'Data Pretendida', 'Hora', 'Estado', 'Data Submissão'], ';');

            foreach ($reunioes as $r) {
                fputcsv($out, [
                    $r->name,
                    $r->email,
                    $r->meeting_type    ?? '',
                    $r->preferred_date  ?? '',
                    $r->preferred_time  ?? '',
                    $r->status,
                    $r->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

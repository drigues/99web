<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPackageRequestController extends Controller
{
    private const STATUSES = ['novo', 'contactado', 'proposta_enviada', 'aprovado', 'recusado'];

    public function index(Request $request): View
    {
        $query = PackageRequest::latest();

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

        if ($type = $request->input('package_type')) {
            $query->where('package_type', $type);
        }

        $pedidos = $query->paginate(15)->withQueryString();
        $packages = config('packages', []);

        return view('admin.pedidos.index', compact('pedidos', 'packages'));
    }

    public function show(PackageRequest $pedido): View
    {
        $package = config('packages.' . $pedido->package_type, []);

        return view('admin.pedidos.show', compact('pedido', 'package'));
    }

    public function updateStatus(Request $request, PackageRequest $pedido): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
        ]);

        $pedido->update(['status' => $request->status]);

        return back()->with('success', 'Estado atualizado para "' . $request->status . '".');
    }

    public function updateNotes(Request $request, PackageRequest $pedido): JsonResponse
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:5000']]);

        $pedido->update(['notes' => $request->notes]);

        return response()->json(['ok' => true]);
    }

    public function destroy(PackageRequest $pedido): RedirectResponse
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado.');
    }
}

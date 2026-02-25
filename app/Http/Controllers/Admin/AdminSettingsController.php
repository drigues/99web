<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /** Keys that are stored as textarea type */
    private const TEXTAREA_KEYS = [
        'site_address', 'site_hours', 'seo_description',
        'email_contact_confirmation', 'email_meeting_confirmation',
    ];

    public function index(): View
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        $packages = config('packages', []);

        return view('admin.configuracoes.index', compact('settings', 'packages'));
    }

    public function update(Request $request): JsonResponse
    {
        $tab  = $request->input('tab', 'geral');
        $data = $request->except(['_token', 'tab']);

        foreach ($data as $key => $value) {
            $type = $this->resolveType($key, $value);

            // Features arrive as newline-separated text → JSON array
            if ($type === 'json' && is_string($value)) {
                $value = array_values(array_filter(
                    array_map('trim', explode("\n", $value))
                ));
            }

            // Boolean checkboxes: absent = false, present = true
            if ($type === 'boolean') {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }

            SiteSetting::set($key, $value, $type, $tab);
        }

        // Handle boolean keys that may be missing from the request (unchecked checkboxes)
        $booleanKeysForTab = $this->booleanKeysForTab($tab);
        foreach ($booleanKeysForTab as $boolKey) {
            if (! array_key_exists($boolKey, $data)) {
                SiteSetting::set($boolKey, false, 'boolean', $tab);
            }
        }

        ActivityLog::record('updated', null, "Configurações guardadas: {$tab}");

        return response()->json(['ok' => true, 'message' => 'Configurações guardadas!']);
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:png,svg,webp,jpg', 'max:1024'],
        ]);

        $path = $request->file('logo')->store('site', 'public');
        $url  = Storage::disk('public')->url($path);

        SiteSetting::set('site_logo', $url, 'text', 'geral');

        return response()->json(['ok' => true, 'url' => $url]);
    }

    // ─── Private helpers ──────────────────────────────────────

    private function resolveType(string $key, mixed $value): string
    {
        if (str_ends_with($key, '_active'))   return 'boolean';
        if (str_ends_with($key, '_features')) return 'json';
        if (in_array($key, self::TEXTAREA_KEYS)) return 'textarea';
        return 'text';
    }

    private function booleanKeysForTab(string $tab): array
    {
        return match ($tab) {
            'pacotes' => [
                'package_essencial_active',
                'package_corporativo_active',
                'package_personalizado_active',
            ],
            default => [],
        };
    }
}

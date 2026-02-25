<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ShareSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        // Share all site settings as a keyed Collection.
        // In Blade: {{ $siteSettings->get('site_name') }}
        $settings = SiteSetting::all()->mapWithKeys(function ($s) {
            $value = match ($s->type) {
                'boolean' => filter_var($s->value, FILTER_VALIDATE_BOOLEAN),
                'json'    => json_decode($s->value, true),
                default   => $s->value,
            };
            return [$s->key => $value];
        });

        view()->share('siteSettings', $settings);

        return $next($request);
    }
}

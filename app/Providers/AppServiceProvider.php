<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('site_settings')) {
            view()->composer('*', function ($view) {
                $settings = Cache::remember('site_settings', 3600, function () {
                    return SiteSetting::pluck('value', 'key');
                });
                $view->with('settings', $settings);
            });
        }
    }
}

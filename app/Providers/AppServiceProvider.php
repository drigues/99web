<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
            View::composer('*', function ($view) {
                // Skip Filament/Livewire views for performance
                $name = $view->getName();
                if (str_starts_with($name, 'filament.') || str_starts_with($name, 'livewire.')) {
                    return;
                }

                $settings = SiteSetting::getAllCached();
                $view->with('settings', collect($settings));
            });
        }
    }
}

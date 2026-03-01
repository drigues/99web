<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BlogPostResource;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function clearCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        Notification::make()
            ->title('Cache limpa com sucesso')
            ->success()
            ->send();
    }

    public function getNewPostUrl(): string
    {
        return BlogPostResource::getUrl('create');
    }
}

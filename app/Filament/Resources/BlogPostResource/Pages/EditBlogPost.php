<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Pré-visualizar')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => url('/blog/' . $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published),
            Actions\DeleteAction::make(),
        ];
    }
}

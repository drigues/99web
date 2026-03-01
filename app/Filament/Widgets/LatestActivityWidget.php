<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivityWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Atividade Recente';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityLog::query()->with('admin')->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin')
                    ->placeholder('Sistema'),
                Tables\Columns\TextColumn::make('action')
                    ->label('Ação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created'   => 'success',
                        'updated'   => 'info',
                        'deleted'   => 'danger',
                        'published' => 'primary',
                        'login'     => 'gray',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created'   => 'Criado',
                        'updated'   => 'Atualizado',
                        'deleted'   => 'Eliminado',
                        'published' => 'Publicado',
                        'login'     => 'Login',
                        'export'    => 'Exportado',
                        default     => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(60),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageRequestResource\Pages;
use App\Models\PackageRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageRequestResource extends Resource
{
    protected static ?string $model = PackageRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Pedidos';
    protected static ?string $modelLabel = 'Pedido de Pacote';
    protected static ?string $pluralModelLabel = 'Pedidos de Pacotes';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'novo')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados do Cliente')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')->disabled(),
                    Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                    Forms\Components\TextInput::make('phone')->label('Telefone')->disabled(),
                    Forms\Components\TextInput::make('company')->label('Empresa')->disabled(),
                    Forms\Components\TextInput::make('current_website')->label('Website Atual')->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Detalhes do Pedido')
                ->schema([
                    Forms\Components\Select::make('package_type')
                        ->label('Tipo de Pacote')
                        ->options([
                            'essencial'     => 'Essencial',
                            'corporativo'   => 'Corporativo',
                            'personalizado' => 'Personalizado',
                        ])
                        ->disabled(),
                    Forms\Components\TextInput::make('budget')->label('Orçamento')->disabled(),
                    Forms\Components\Toggle::make('has_domain')->label('Tem Domínio')->disabled(),
                    Forms\Components\Toggle::make('has_hosting')->label('Tem Hosting')->disabled(),
                    Forms\Components\DatePicker::make('deadline')->label('Prazo')->disabled(),
                    Forms\Components\Textarea::make('project_description')
                        ->label('Descrição do Projeto')->disabled()->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Gestão')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Estado')
                        ->options([
                            'novo'             => 'Novo',
                            'contactado'       => 'Contactado',
                            'proposta_enviada' => 'Proposta Enviada',
                            'aprovado'         => 'Aprovado',
                            'recusado'         => 'Recusado',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('notes')->label('Notas internas')->rows(4)->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('company')->label('Empresa')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('package_type')
                    ->label('Pacote')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'essencial'     => 'info',
                        'corporativo'   => 'warning',
                        'personalizado' => 'primary',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\IconColumn::make('has_domain')->label('Domínio')->boolean()->toggleable(),
                Tables\Columns\IconColumn::make('has_hosting')->label('Hosting')->boolean()->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'novo'             => 'warning',
                        'contactado'       => 'info',
                        'proposta_enviada' => 'primary',
                        'aprovado'         => 'success',
                        'recusado'         => 'danger',
                        default            => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'novo'             => 'Novo',
                        'contactado'       => 'Contactado',
                        'proposta_enviada' => 'Proposta Enviada',
                        'aprovado'         => 'Aprovado',
                        'recusado'         => 'Recusado',
                        default            => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'novo'             => 'Novo',
                        'contactado'       => 'Contactado',
                        'proposta_enviada' => 'Proposta Enviada',
                        'aprovado'         => 'Aprovado',
                        'recusado'         => 'Recusado',
                    ]),
                Tables\Filters\SelectFilter::make('package_type')
                    ->label('Pacote')
                    ->options([
                        'essencial'     => 'Essencial',
                        'corporativo'   => 'Corporativo',
                        'personalizado' => 'Personalizado',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('enviar_proposta')
                    ->label('Enviar Proposta')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Enviar Proposta')
                    ->modalDescription('Marcar este pedido como "Proposta Enviada"?')
                    ->visible(fn (PackageRequest $record): bool => in_array($record->status, ['novo', 'contactado']))
                    ->action(fn (PackageRequest $record) => $record->update(['status' => 'proposta_enviada'])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackageRequests::route('/'),
            'view'  => Pages\ViewPackageRequest::route('/{record}'),
            'edit'  => Pages\EditPackageRequest::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Contactos';
    protected static ?string $modelLabel = 'Contacto';
    protected static ?string $pluralModelLabel = 'Contactos';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'novo')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informação do Contacto')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')->disabled(),
                    Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                    Forms\Components\TextInput::make('phone')->label('Telefone')->disabled(),
                    Forms\Components\TextInput::make('company')->label('Empresa')->disabled(),
                    Forms\Components\TextInput::make('website_url')->label('Website')->disabled(),
                    Forms\Components\TextInput::make('source')->label('Origem')->disabled(),
                    Forms\Components\Textarea::make('message')->label('Mensagem')->disabled()->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Gestão')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Estado')
                        ->options([
                            'novo'       => 'Novo',
                            'em_analise' => 'Em Análise',
                            'respondido' => 'Respondido',
                            'fechado'    => 'Fechado',
                        ])
                        ->required(),
                    Forms\Components\DateTimePicker::make('responded_at')->label('Respondido em')->disabled(),
                    Forms\Components\Textarea::make('notes')->label('Notas internas')->rows(4)->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->label('Telefone')->toggleable(),
                Tables\Columns\TextColumn::make('company')->label('Empresa')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('source')
                    ->label('Origem')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cta_header' => 'info',
                        'cta_footer' => 'success',
                        'cta_hero'   => 'primary',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'novo'       => 'warning',
                        'em_analise' => 'info',
                        'respondido' => 'success',
                        'fechado'    => 'gray',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'novo'       => 'Novo',
                        'em_analise' => 'Em Análise',
                        'respondido' => 'Respondido',
                        'fechado'    => 'Fechado',
                    ]),
                Tables\Filters\SelectFilter::make('source')
                    ->label('Origem')
                    ->options([
                        'cta_header' => 'CTA Header',
                        'cta_footer' => 'CTA Footer',
                        'cta_hero'   => 'CTA Hero',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('marcar_respondido')
                    ->label('Marcar Respondido')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Contact $record): bool => $record->status !== 'respondido')
                    ->action(fn (Contact $record) => $record->markAsResponded()),
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
            'index' => Pages\ListContacts::route('/'),
            'view'  => Pages\ViewContact::route('/{record}'),
            'edit'  => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}

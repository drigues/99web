<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingRequestResource\Pages;
use App\Mail\MeetingConfirmation;
use App\Models\MeetingRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class MeetingRequestResource extends Resource
{
    protected static ?string $model = MeetingRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Reuniões';
    protected static ?string $modelLabel = 'Reunião';
    protected static ?string $pluralModelLabel = 'Reuniões';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pendente')->count() ?: null;
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

            Forms\Components\Section::make('Detalhes da Reunião')
                ->schema([
                    Forms\Components\DatePicker::make('preferred_date')->label('Data Pretendida')->disabled(),
                    Forms\Components\TimePicker::make('preferred_time')->label('Hora Pretendida')->disabled(),
                    Forms\Components\Select::make('meeting_type')
                        ->label('Tipo de Reunião')
                        ->options([
                            'video_call'  => 'Video Call',
                            'phone'       => 'Telefone',
                            'presencial'  => 'Presencial',
                        ])
                        ->disabled(),
                    Forms\Components\Textarea::make('objectives')->label('Objetivos')->disabled()->columnSpanFull(),
                ])
                ->columns(3),

            Forms\Components\Section::make('Gestão')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Estado')
                        ->options([
                            'pendente'   => 'Pendente',
                            'confirmado' => 'Confirmado',
                            'realizado'  => 'Realizado',
                            'cancelado'  => 'Cancelado',
                            'reagendado' => 'Reagendado',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('confirmed_date')->label('Data Confirmada'),
                    Forms\Components\TimePicker::make('confirmed_time')->label('Hora Confirmada'),
                    Forms\Components\Textarea::make('admin_notes')->label('Notas do Admin')->rows(4)->columnSpanFull(),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('meeting_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'video_call' => 'info',
                        'phone'      => 'warning',
                        'presencial' => 'success',
                        default      => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'video_call' => 'Video Call',
                        'phone'      => 'Telefone',
                        'presencial' => 'Presencial',
                        default      => $state,
                    }),
                Tables\Columns\TextColumn::make('preferred_date')->label('Data Pretendida')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('preferred_time')->label('Hora'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente'   => 'warning',
                        'confirmado' => 'success',
                        'realizado'  => 'gray',
                        'cancelado'  => 'danger',
                        'reagendado' => 'info',
                        default      => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('confirmed_date')
                    ->label('Confirmado')->date('d/m/Y')->toggleable()->placeholder('--'),
                Tables\Columns\TextColumn::make('created_at')->label('Submetido')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendente'   => 'Pendente',
                        'confirmado' => 'Confirmado',
                        'realizado'  => 'Realizado',
                        'cancelado'  => 'Cancelado',
                        'reagendado' => 'Reagendado',
                    ]),
                Tables\Filters\SelectFilter::make('meeting_type')
                    ->label('Tipo')
                    ->options([
                        'video_call' => 'Video Call',
                        'phone'      => 'Telefone',
                        'presencial' => 'Presencial',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('confirmar')
                    ->label('Confirmar Reunião')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (MeetingRequest $record): bool => in_array($record->status, ['pendente', 'reagendado']))
                    ->form([
                        Forms\Components\DatePicker::make('confirmed_date')
                            ->label('Data Confirmada')->required()->minDate(now()),
                        Forms\Components\TimePicker::make('confirmed_time')
                            ->label('Hora Confirmada')->required(),
                    ])
                    ->action(function (MeetingRequest $record, array $data): void {
                        $record->confirm($data['confirmed_date'], $data['confirmed_time']);

                        try {
                            Mail::to($record->email)->send(new MeetingConfirmation($record));
                        } catch (\Throwable) {
                            // Silently fail if mail fails
                        }

                        Notification::make()
                            ->title('Reunião confirmada')
                            ->body('Email de confirmação enviado para ' . $record->email)
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListMeetingRequests::route('/'),
            'view'  => Pages\ViewMeetingRequest::route('/{record}'),
            'edit'  => Pages\EditMeetingRequest::route('/{record}/edit'),
        ];
    }
}

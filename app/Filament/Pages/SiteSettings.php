<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?string $navigationLabel = 'Configurações';

    protected static ?string $title = 'Configurações do Site';

    protected static ?string $slug = 'configuracoes';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Load directly from DB (bypass cache) to always show fresh values
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // Cast booleans for Toggle fields
        $booleanKeys = [
            'package_essencial_active', 'package_corporativo_active',
            'package_personalizado_active', 'show_loader',
        ];
        foreach ($booleanKeys as $key) {
            if (isset($settings[$key])) {
                $settings[$key] = filter_var($settings[$key], FILTER_VALIDATE_BOOLEAN);
            }
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Configurações')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Geral')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Nome do Site')
                                    ->default('99web'),
                                Forms\Components\Textarea::make('site_description')
                                    ->label('Descrição do Site')
                                    ->rows(3),
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Email de Contacto')
                                    ->email(),
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Telefone')
                                    ->tel(),
                                Forms\Components\Textarea::make('contact_address')
                                    ->label('Morada')
                                    ->rows(2),
                                Forms\Components\TextInput::make('working_hours')
                                    ->label('Horário de Funcionamento')
                                    ->default('Seg-Sex 9h-18h'),
                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('WhatsApp')
                                    ->placeholder('+351...'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Redes Sociais')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('social_facebook')
                                    ->label('Facebook')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_linkedin')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_twitter')
                                    ->label('Twitter / X')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_youtube')
                                    ->label('YouTube')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_github')
                                    ->label('GitHub')
                                    ->url()
                                    ->prefix('https://'),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO & Analytics')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title_home')
                                    ->label('Meta Title (Home)')
                                    ->maxLength(60)
                                    ->live(onBlur: true)
                                    ->hint(fn ($state) => strlen($state ?? '') . '/60 caracteres'),
                                Forms\Components\Textarea::make('meta_description_home')
                                    ->label('Meta Description (Home)')
                                    ->maxLength(160)
                                    ->live(onBlur: true)
                                    ->hint(fn ($state) => strlen($state ?? '') . '/160 caracteres')
                                    ->rows(3),
                                Forms\Components\TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX'),
                                Forms\Components\TextInput::make('google_search_console')
                                    ->label('Google Search Console')
                                    ->placeholder('Código de verificação'),
                                Forms\Components\TextInput::make('facebook_pixel_id')
                                    ->label('Facebook Pixel ID'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Email')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Forms\Components\TextInput::make('notification_email')
                                    ->label('Email de Notificações')
                                    ->helperText('Para onde vão os alertas de novos contactos')
                                    ->email(),
                                Forms\Components\TextInput::make('sender_name')
                                    ->label('Nome do Remetente')
                                    ->default('99web'),
                                Forms\Components\RichEditor::make('contact_confirmation_text')
                                    ->label('Texto de Confirmação (Contacto)')
                                    ->helperText('Texto enviado ao cliente após submeter contacto'),
                                Forms\Components\RichEditor::make('meeting_confirmation_text')
                                    ->label('Texto de Confirmação (Reunião)')
                                    ->helperText('Texto enviado ao cliente após agendar reunião'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Pacotes')
                            ->icon('heroicon-o-shopping-bag')
                            ->schema([
                                Forms\Components\Section::make('Web Essencial')
                                    ->schema([
                                        Forms\Components\Toggle::make('package_essencial_active')
                                            ->label('Ativo no site')
                                            ->default(true),
                                        Forms\Components\TextInput::make('package_essencial_price')
                                            ->label('Preço')
                                            ->default('399€'),
                                        Forms\Components\Textarea::make('package_essencial_features')
                                            ->label('Features (uma por linha)')
                                            ->rows(6)
                                            ->columnSpanFull(),
                                    ])->columns(2)->collapsible(),

                                Forms\Components\Section::make('Web Corporativo')
                                    ->schema([
                                        Forms\Components\Toggle::make('package_corporativo_active')
                                            ->label('Ativo no site')
                                            ->default(true),
                                        Forms\Components\TextInput::make('package_corporativo_price')
                                            ->label('Preço')
                                            ->default('599€'),
                                        Forms\Components\Textarea::make('package_corporativo_features')
                                            ->label('Features (uma por linha)')
                                            ->rows(8)
                                            ->columnSpanFull(),
                                    ])->columns(2)->collapsible(),

                                Forms\Components\Section::make('Projetos Personalizados')
                                    ->schema([
                                        Forms\Components\Toggle::make('package_personalizado_active')
                                            ->label('Ativo no site')
                                            ->default(true),
                                        Forms\Components\TextInput::make('package_personalizado_price')
                                            ->label('Preço')
                                            ->default('Sob consulta'),
                                        Forms\Components\Textarea::make('package_personalizado_features')
                                            ->label('Features (uma por linha)')
                                            ->rows(6)
                                            ->columnSpanFull(),
                                    ])->columns(2)->collapsible(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Aparência')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Forms\Components\Select::make('default_theme')
                                    ->label('Tema Padrão')
                                    ->options([
                                        'dark' => 'Escuro',
                                        'light' => 'Claro',
                                    ])
                                    ->default('dark'),
                                Forms\Components\ColorPicker::make('primary_color')
                                    ->label('Cor Principal')
                                    ->default('#7C3AED'),
                                Forms\Components\Toggle::make('show_loader')
                                    ->label('Mostrar Loader')
                                    ->default(true),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if ($key === '' || $key === null) {
                continue;
            }

            $group = $this->getGroupForKey($key);

            // Convert booleans to string for storage
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => (string) ($value ?? ''), 'group' => $group, 'type' => 'text']
            );
        }

        // Clear cache so public views reflect changes immediately
        SiteSetting::clearCache();

        Notification::make()
            ->title('Configurações guardadas!')
            ->body('As alterações já estão visíveis no site.')
            ->success()
            ->send();
    }

    protected function getGroupForKey(string $key): string
    {
        return match (true) {
            str_starts_with($key, 'social_') => 'social',
            str_starts_with($key, 'meta_'), str_starts_with($key, 'google_'), str_starts_with($key, 'facebook_pixel') => 'seo',
            str_starts_with($key, 'notification_'), str_starts_with($key, 'sender_'), str_ends_with($key, '_confirmation_text') => 'email',
            str_starts_with($key, 'package_') => 'packages',
            in_array($key, ['default_theme', 'primary_color', 'show_loader']) => 'appearance',
            default => 'general',
        };
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

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
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // Cast booleans for Toggle fields
        $booleanKeys = [
            'package_essencial_active', 'package_corporativo_active',
            'package_personalizado_active', 'package_essencial_popular',
            'package_corporativo_popular', 'package_personalizado_popular',
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
                Forms\Components\Tabs::make('Settings')
                    ->tabs([

                        // ===== TAB GERAL =====
                        Forms\Components\Tabs\Tab::make('Geral')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\Section::make('Informações da Empresa')->schema([
                                    Forms\Components\TextInput::make('site_name')
                                        ->label('Nome do Site')
                                        ->required(),
                                    Forms\Components\Textarea::make('site_description')
                                        ->label('Descrição da Empresa')
                                        ->rows(2),
                                    Forms\Components\TextInput::make('contact_email')
                                        ->label('Email')
                                        ->email()
                                        ->required(),
                                    Forms\Components\TextInput::make('contact_phone')
                                        ->label('Telefone')
                                        ->tel(),
                                    Forms\Components\TextInput::make('whatsapp_number')
                                        ->label('WhatsApp')
                                        ->placeholder('+351912345678'),
                                    Forms\Components\Textarea::make('contact_address')
                                        ->label('Morada')
                                        ->rows(2),
                                    Forms\Components\TextInput::make('working_hours')
                                        ->label('Horário'),
                                ])->columns(2),
                                Forms\Components\Section::make('Footer')->schema([
                                    Forms\Components\Textarea::make('footer_tagline')
                                        ->label('Tagline do Footer')
                                        ->rows(2),
                                    Forms\Components\TextInput::make('copyright_text')
                                        ->label('Texto Copyright'),
                                ]),
                            ]),

                        // ===== TAB HERO =====
                        Forms\Components\Tabs\Tab::make('Hero')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Forms\Components\Section::make('Título (uma linha por campo)')->schema([
                                    Forms\Components\TextInput::make('hero_title_line1')
                                        ->label('Linha 1'),
                                    Forms\Components\TextInput::make('hero_title_line2')
                                        ->label('Linha 2'),
                                    Forms\Components\TextInput::make('hero_title_line3')
                                        ->label('Linha 3 (destaque)'),
                                ]),
                                Forms\Components\Textarea::make('hero_subtitle')
                                    ->label('Subtítulo')
                                    ->rows(3),
                                Forms\Components\Section::make('Botões')->schema([
                                    Forms\Components\TextInput::make('hero_cta_primary')
                                        ->label('Botão Principal'),
                                    Forms\Components\TextInput::make('hero_cta_secondary')
                                        ->label('Botão Secundário'),
                                ])->columns(2),
                                Forms\Components\Section::make('Estatísticas')->schema([
                                    Forms\Components\Fieldset::make('Stat 1')->schema([
                                        Forms\Components\TextInput::make('hero_stat1_value')->label('Valor'),
                                        Forms\Components\TextInput::make('hero_stat1_label')->label('Label'),
                                    ])->columns(2),
                                    Forms\Components\Fieldset::make('Stat 2')->schema([
                                        Forms\Components\TextInput::make('hero_stat2_value')->label('Valor'),
                                        Forms\Components\TextInput::make('hero_stat2_label')->label('Label'),
                                    ])->columns(2),
                                ]),
                            ]),

                        // ===== TAB PACOTES =====
                        Forms\Components\Tabs\Tab::make('Pacotes')
                            ->icon('heroicon-o-currency-euro')
                            ->schema([
                                Forms\Components\Section::make('Web Essencial')
                                    ->description('Plano de entrada')
                                    ->schema(static::packageFields('essencial'))
                                    ->collapsible(),
                                Forms\Components\Section::make('Web Corporativo')
                                    ->description('Plano intermédio')
                                    ->schema(static::packageFields('corporativo'))
                                    ->collapsible(),
                                Forms\Components\Section::make('Projetos Personalizados')
                                    ->description('Plano custom')
                                    ->schema(static::packageFields('personalizado'))
                                    ->collapsible(),
                            ]),

                        // ===== TAB REDES SOCIAIS =====
                        Forms\Components\Tabs\Tab::make('Redes Sociais')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('social_instagram')->label('Instagram')->url(),
                                Forms\Components\TextInput::make('social_linkedin')->label('LinkedIn')->url(),
                                Forms\Components\TextInput::make('social_github')->label('GitHub')->url(),
                                Forms\Components\TextInput::make('social_facebook')->label('Facebook')->url(),
                                Forms\Components\TextInput::make('social_twitter')->label('Twitter / X')->url(),
                                Forms\Components\TextInput::make('social_youtube')->label('YouTube')->url(),
                            ]),

                        // ===== TAB SEO =====
                        Forms\Components\Tabs\Tab::make('SEO & Analytics')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\Section::make('Meta Tags Homepage')->schema([
                                    Forms\Components\TextInput::make('meta_title_home')
                                        ->label('Meta Title')
                                        ->maxLength(60)
                                        ->live(debounce: 500)
                                        ->hint(fn ($state) => strlen($state ?? '') . '/60 caracteres'),
                                    Forms\Components\Textarea::make('meta_description_home')
                                        ->label('Meta Description')
                                        ->maxLength(160)
                                        ->rows(2)
                                        ->live(debounce: 500)
                                        ->hint(fn ($state) => strlen($state ?? '') . '/160 caracteres'),
                                ]),
                                Forms\Components\Section::make('Tracking & Analytics')->schema([
                                    Forms\Components\TextInput::make('google_analytics_id')
                                        ->label('Google Analytics 4')
                                        ->placeholder('G-XXXXXXXXXX'),
                                    Forms\Components\TextInput::make('google_search_console')
                                        ->label('Google Search Console'),
                                    Forms\Components\TextInput::make('facebook_pixel_id')
                                        ->label('Facebook Pixel'),
                                ])->columns(2),
                            ]),

                        // ===== TAB EMAIL =====
                        Forms\Components\Tabs\Tab::make('Email')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Forms\Components\TextInput::make('notification_email')
                                    ->label('Email para Notificações')
                                    ->email()
                                    ->hint('Novos contactos, pedidos e reuniões'),
                                Forms\Components\TextInput::make('sender_name')
                                    ->label('Nome do Remetente'),
                            ]),

                        // ===== TAB CTA =====
                        Forms\Components\Tabs\Tab::make('CTA Final')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Forms\Components\TextInput::make('cta_title')
                                    ->label('Título'),
                                Forms\Components\Textarea::make('cta_subtitle')
                                    ->label('Subtítulo')
                                    ->rows(2),
                                Forms\Components\TextInput::make('cta_button_text')
                                    ->label('Texto do Botão'),
                                Forms\Components\TextInput::make('cta_disclaimer')
                                    ->label('Texto pequeno abaixo'),
                            ]),

                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    /**
     * Campos reutilizáveis para cada pacote.
     */
    protected static function packageFields(string $type): array
    {
        return [
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Toggle::make("package_{$type}_active")
                    ->label('Ativo no site')
                    ->default(true),
                Forms\Components\Toggle::make("package_{$type}_popular")
                    ->label('Mais Popular')
                    ->hint('Destaca este pacote com badge e visual diferenciado'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make("package_{$type}_name")
                    ->label('Nome do Pacote')
                    ->required(),
                Forms\Components\TextInput::make("package_{$type}_badge")
                    ->label('Badge')
                    ->placeholder('Ex: STARTER, MAIS POPULAR, CUSTOM'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make("package_{$type}_price_original")
                    ->label('Preço Anterior')
                    ->placeholder('799')
                    ->hint('Riscado no card. Vazio = não mostra')
                    ->prefix('€'),
                Forms\Components\TextInput::make("package_{$type}_price_final")
                    ->label('Preço Final')
                    ->placeholder('599 ou "Sob consulta"')
                    ->required(),
                Forms\Components\Placeholder::make("package_{$type}_discount")
                    ->label('Desconto')
                    ->content(function (Get $get) use ($type) {
                        $original = (int) $get("package_{$type}_price_original");
                        $final = (int) $get("package_{$type}_price_final");
                        if ($original > 0 && $final > 0 && $original > $final) {
                            $discount = round((($original - $final) / $original) * 100);
                            $savings = $original - $final;

                            return "-{$discount}% (poupa {$savings}€)";
                        }

                        return '-';
                    }),
            ]),
            Forms\Components\TextInput::make("package_{$type}_cta_text")
                ->label('Texto do Botão')
                ->placeholder('Ex: Escolher este plano'),
            Forms\Components\Textarea::make("package_{$type}_features")
                ->label('Features (uma por linha)')
                ->rows(6)
                ->hint('Cada linha aparece como um item com check no card'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if ($key === '' || $key === null) {
                continue;
            }

            $group = match (true) {
                str_starts_with($key, 'social_') => 'social',
                str_starts_with($key, 'meta_'), str_starts_with($key, 'google_'), str_starts_with($key, 'facebook_pixel') => 'seo',
                str_starts_with($key, 'package_') => 'packages',
                str_starts_with($key, 'notification_'), str_starts_with($key, 'sender_') => 'email',
                str_starts_with($key, 'hero_') => 'hero',
                str_starts_with($key, 'cta_') => 'cta',
                default => 'general',
            };

            $dbValue = is_bool($value) ? ($value ? '1' : '0') : (string) ($value ?? '');

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $dbValue, 'group' => $group, 'type' => 'text']
            );
        }

        SiteSetting::clearCache();

        Notification::make()
            ->success()
            ->title('Configurações guardadas!')
            ->body('Alterações visíveis no site público.')
            ->send();
    }
}

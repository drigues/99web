<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Conteúdo';
    protected static ?string $navigationLabel = 'Blog Posts';
    protected static ?string $modelLabel = 'Post';
    protected static ?string $pluralModelLabel = 'Posts';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // ─── Main Content (2/3) ─────────────────────────────
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Conteúdo')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Título')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                    if (($get('slug') ?? '') !== Str::slug($old)) {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                })
                                ->columnSpanFull()
                                ->extraAttributes(['class' => 'text-2xl']),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->prefix(config('app.url') . '/blog/')
                                ->columnSpanFull(),

                            Forms\Components\Textarea::make('excerpt')
                                ->label('Resumo')
                                ->required()
                                ->rows(3)
                                ->maxLength(300)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/300 caracteres')
                                ->live(debounce: 500)
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('content')
                                ->label('Conteúdo')
                                ->required()
                                ->toolbarButtons([
                                    'bold', 'italic', 'h2', 'h3', 'link',
                                    'bulletList', 'orderedList', 'blockquote',
                                    'codeBlock', 'attachFiles',
                                ])
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('blog/content')
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Section::make('Posts Relacionados')
                        ->schema([
                            Forms\Components\Select::make('relatedPosts')
                                ->label('Posts Relacionados (manual)')
                                ->multiple()
                                ->relationship('relatedPosts', 'title')
                                ->searchable()
                                ->preload()
                                ->hint('Se vazio, são sugeridos automaticamente pela mesma categoria'),

                            Forms\Components\Placeholder::make('auto_related')
                                ->label('Sugestão Automática')
                                ->content(function (?BlogPost $record): string {
                                    if (! $record) {
                                        return 'Guarde o post primeiro para ver sugestões.';
                                    }

                                    $related = BlogPost::published()
                                        ->where('id', '!=', $record->id)
                                        ->where('category_id', $record->category_id)
                                        ->latest('published_at')
                                        ->limit(3)
                                        ->pluck('title');

                                    return $related->isEmpty()
                                        ? 'Sem posts na mesma categoria.'
                                        : $related->join(', ');
                                }),
                        ])
                        ->collapsible()
                        ->collapsed(),
                ])
                ->columnSpan(['lg' => 2]),

            // ─── Sidebar (1/3) ──────────────────────────────────
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Publicação')
                        ->schema([
                            Forms\Components\Toggle::make('is_published')
                                ->label('Publicado')
                                ->default(false),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Data de publicação')
                                ->default(now())
                                ->hint('Pode agendar para o futuro'),

                            Forms\Components\Placeholder::make('views')
                                ->label('Visualizações')
                                ->content(fn (?BlogPost $record): string => (string) ($record?->views_count ?? 0)),

                            Forms\Components\Placeholder::make('reading_time_display')
                                ->label('Tempo de leitura')
                                ->content(fn (?BlogPost $record): string => ($record?->reading_time ?? 0) . ' min'),
                        ]),

                    Forms\Components\Section::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta Título')
                                ->maxLength(60)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/60')
                                ->live(debounce: 500)
                                ->placeholder(fn (Get $get): string => $get('title') ?? ''),

                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Descrição')
                                ->maxLength(160)
                                ->rows(3)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/160')
                                ->live(debounce: 500)
                                ->placeholder(fn (Get $get): string => Str::limit($get('excerpt') ?? '', 155)),

                            Forms\Components\TextInput::make('meta_keywords')
                                ->label('Palavras-chave')
                                ->placeholder('laravel, web design, portugal'),

                            Forms\Components\TextInput::make('canonical_url')
                                ->label('URL Canónica')
                                ->url()
                                ->placeholder('Deixar vazio para usar URL padrão'),

                            Forms\Components\ViewField::make('seo_preview')
                                ->label('Preview Google')
                                ->view('filament.components.seo-preview'),
                        ]),

                    Forms\Components\Section::make('Imagem Destaque')
                        ->schema([
                            Forms\Components\FileUpload::make('featured_image')
                                ->label('Imagem')
                                ->image()
                                ->disk('public')
                                ->directory('blog/featured')
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth(1200)
                                ->imageResizeTargetHeight(675),

                            Forms\Components\FileUpload::make('og_image')
                                ->label('Imagem OG (opcional)')
                                ->image()
                                ->disk('public')
                                ->directory('blog/og')
                                ->hint('Se vazio, usa a imagem destaque'),
                        ]),

                    Forms\Components\Section::make('Classificação')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Categoria')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nome')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug')
                                        ->required(),
                                ]),

                            Forms\Components\Select::make('tags')
                                ->label('Tags')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nome')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug')
                                        ->required(),
                                ]),

                            Forms\Components\Select::make('author_id')
                                ->label('Autor')
                                ->relationship('author', 'name')
                                ->default(fn () => auth('admin')->id())
                                ->required(),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('')
                    ->disk('public')
                    ->circular(false)
                    ->width(80)
                    ->height(45)
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=B&color=7C3AED&background=EDE9FE'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('--'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('is_published')
                    ->label('Estado')
                    ->options([
                        1 => 'Publicados',
                        0 => 'Rascunhos',
                    ]),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('togglePublish')
                    ->label(fn (BlogPost $record): string => $record->is_published ? 'Despublicar' : 'Publicar')
                    ->icon(fn (BlogPost $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (BlogPost $record): string => $record->is_published ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->action(function (BlogPost $record): void {
                        $record->update([
                            'is_published' => ! $record->is_published,
                            'published_at' => ! $record->is_published ? ($record->published_at ?? now()) : $record->published_at,
                        ]);
                    }),

                Tables\Actions\Action::make('viewOnSite')
                    ->label('Ver no site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (BlogPost $record): string => '/blog/' . $record->slug)
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publicar')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(fn (BlogPost $record) => $record->update([
                            'is_published' => true,
                            'published_at' => $record->published_at ?? now(),
                        ]))),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Despublicar')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(fn (BlogPost $record) => $record->update([
                            'is_published' => false,
                        ]))),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}

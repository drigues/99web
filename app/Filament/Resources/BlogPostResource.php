<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\AdminUser;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
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
                                }),
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Forms\Components\Textarea::make('excerpt')
                                ->label('Resumo')
                                ->rows(3)
                                ->maxLength(300)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/300'),
                            Forms\Components\RichEditor::make('content')
                                ->label('Conteúdo')
                                ->required()
                                ->columnSpanFull()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('blog/content'),
                        ]),
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
                                ->label('Data de Publicação'),
                            Forms\Components\Select::make('author_id')
                                ->label('Autor')
                                ->relationship('author', 'name')
                                ->default(fn () => auth('admin')->id())
                                ->required(),
                        ]),

                    Forms\Components\Section::make('Taxonomia')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Categoria')
                                ->relationship('category', 'name')
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nome')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug')
                                        ->required(),
                                ])
                                ->required(),
                            Forms\Components\Select::make('tags')
                                ->label('Tags')
                                ->relationship('tags', 'name')
                                ->multiple()
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
                        ]),

                    Forms\Components\Section::make('Imagens')
                        ->schema([
                            Forms\Components\FileUpload::make('featured_image')
                                ->label('Imagem Destaque')
                                ->image()
                                ->directory('blog')
                                ->maxSize(2048)
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1200')
                                ->imageResizeTargetHeight('675'),
                            Forms\Components\FileUpload::make('og_image')
                                ->label('OG Image')
                                ->image()
                                ->directory('blog/og')
                                ->maxSize(1024),
                        ]),

                    Forms\Components\Section::make('SEO')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->maxLength(60)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/60'),
                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->maxLength(160)
                                ->rows(2)
                                ->hint(fn (?string $state): string => strlen($state ?? '') . '/160'),
                            Forms\Components\TextInput::make('meta_keywords')
                                ->label('Keywords'),
                            Forms\Components\TextInput::make('canonical_url')
                                ->label('Canonical URL')
                                ->url(),
                        ])
                        ->collapsible()
                        ->collapsed(),
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
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=B&color=7C3AED&background=EDE9FE')
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->description(fn (BlogPost $record): string => $record->slug)
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Autor')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('--'),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Autor')
                    ->relationship('author', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publicado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_publish')
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
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (BlogPost $record): void {
                        $clone = $record->replicate(['views_count', 'is_published', 'published_at']);
                        $clone->title = $record->title . ' (cópia)';
                        $clone->slug = Str::slug($clone->title);
                        $clone->is_published = false;
                        $clone->views_count = 0;
                        $clone->save();

                        $clone->tags()->sync($record->tags->pluck('id'));

                        Notification::make()
                            ->title('Post duplicado')
                            ->success()
                            ->send();
                    }),
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

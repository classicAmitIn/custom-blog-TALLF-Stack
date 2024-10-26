<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieTagsInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    /**
     * The resource navigation group.
     */
    protected static ?string $navigationGroup = 'Publish';

    /**
     * The resource navigation sort order.
     */
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Section::make()
                            ->columnSpan(2)
                            ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->placeholder('Article Title Goes Here...')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                        ->required()
                                        ->maxLength(255)
                                        ->autofocus(),
                                    Forms\Components\TextInput::make('slug')
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(Article::class, 'slug', ignoreRecord: true),
                                    Forms\Components\Textarea::make('summary')
                                        ->required()
                                        ->rows(5)
                                        ->columnSpanFull(),
                                    Forms\Components\MarkdownEditor::make('body')
                                        ->required()
                                        ->fileAttachmentsDirectory('articles/images')
                                        ->columnSpanFull(),

                            ]),
                            Forms\Components\Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                        ->relationship('user', 'name')
                                        ->required(),
                                Forms\Components\Select::make('category_id')
                                        ->relationship('category', 'title')
                                        ->required(),
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('articles/featured-images')
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                    ]),
                                Forms\Components\TextInput::make('featured_image_caption')
                                    ->label('Image Caption')
                                    ->required(),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->required(),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Article')
                                    ->default(false)
                                    ->required(),
                                SpatieTagsInput::make('tags')
                            ]),
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\ImageColumn::make('user.profile_photo_url')
                //     ->circular(),
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular(),
                // Tables\Columns\TextColumn::make('slug')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    // ->dateTime()
                    ->since()
                    ->sortable(),
                // Tables\Columns\ImageColumn::make('featured_image')
                //     ->circular(),
                // Tables\Columns\ImageColumn::make('featured_image_caption'),
                Tables\Columns\ToggleColumn::make('is_featured'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

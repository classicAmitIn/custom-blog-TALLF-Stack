<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * The resource navigation group.
     */
    protected static ?string $navigationGroup = 'Publish';

    /**
     * The resource navigation sort order.
     */
    protected static ?int $navigationSort = 0;

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
                                        ->placeholder('Category Title Goes Here...')
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
                                        ->unique(Category::class, 'slug', ignoreRecord: true),
                                    Forms\Components\Textarea::make('description')
                                        ->columnSpanFull()
                                        ->rows(5)
                                        ->required(),

                            ]),
                            Forms\Components\Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('text_color')
                                        ->label('Text Color')
                                        ->required(),
                                Forms\Components\TextInput::make('bg_color')
                                        ->label('Background Color')
                                        ->required(),
                                Forms\Components\Toggle::make('is_active')
                                        ->label('Visible to Users.')
                                        ->required()
                                        ->default(false),
                            ]),
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('slug')
                //     ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\ColorColumn::make('text_color')
                    ->label('Text Color'),
                Tables\Columns\ColorColumn::make('bg_color')
                    ->label('Background Color'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
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

<?php

namespace Filament\Resources;

use App\Models\Catalog;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\CatalogResource\Pages;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CatalogResource extends Resource
{
    use Translatable;

    protected static ?string $model = Catalog::class;

    protected static ?string $label = 'katalog';

    protected static ?string $pluralLabel = 'kataloglar';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Kataloglar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Katalog nomi')
                    ->required()
                    ->translatableTabs(),

                FileUpload::make('image')
                    ->label('Katalog rasmi')
                    ->directory('catalogs')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Katalog nomi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('image'),

                ToggleColumn::make('status')->label('Status'),

                TextColumn::make('created_at')->label('Yaratilgan sana')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('O\'zgartirilgan sana')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        if (static::getNavigationBadge() > 0) {
            return 'success';
        } else {
            return 'danger';
        }
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
            'index' => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'view' => Pages\ViewCatalog::route('/{record}'),
            'edit' => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }
}

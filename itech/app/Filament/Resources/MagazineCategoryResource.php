<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MagazineCategoryResource\Pages;
use App\Filament\Resources\MagazineCategoryResource\RelationManagers;
use App\Models\Magazine\MagazineCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MagazineCategoryResource extends Resource
{
    protected static ?string $model = MagazineCategory::class;

    protected static ?string $label = 'kategoriya';

    protected static ?string $navigationGroup = 'Yangiliklar';

    protected static ?string $navigationLabel = 'Kategoriyalar';

    protected static ?string $pluralLabel = 'Kategoriyalar';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->label('Nomi')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function getBreadcrumb(): string
    {
        return self::$navigationLabel;
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
            'index' => Pages\ListMagazineCategories::route('/'),
            'create' => Pages\CreateMagazineCategory::route('/create'),
            'edit' => Pages\EditMagazineCategory::route('/{record}/edit'),
        ];
    }
}

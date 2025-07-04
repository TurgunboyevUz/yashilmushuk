<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MagazineResource\Pages;
use App\Filament\Resources\MagazineResource\RelationManagers;
use App\Models\Magazine\Magazine;
use App\Models\Magazine\MagazineCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MagazineResource extends Resource
{
    protected static ?string $model = Magazine::class;

    protected static ?string $label = 'yangilik';

    protected static ?string $navigationGroup = 'Yangiliklar';

    protected static ?string $navigationLabel = 'Yangiliklar';

    protected static ?string $pluralLabel = 'Yangiliklar';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('magazine_category_id')->label('Kategoriya')->options(MagazineCategory::all()->pluck('name', 'id')->toArray())->required()->native(false),
                TextInput::make('title')->label('Sarlavha')->required(),
                TextInput::make('url')->label('Havola')->required()->url()->columnSpanFull(),
                Textarea::make('description')->label('Tavsif')->required()->columnSpanFull(),
                FileUpload::make('image_path')->label('Rasm')->directory('magazines')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->label('Kategoriya')->sortable(),
                TextColumn::make('title')->label('Sarlavha')->sortable(),
                TextColumn::make('description')->label('Tavsif')->sortable(),
                TextColumn::make('url')->label('Havola')->sortable(),
                ImageColumn::make('image_path')->label('Rasm')->sortable(),
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

    public static function getBreadcrumb(): string
    {
        return self::$navigationLabel;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
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
            'index' => Pages\ListMagazines::route('/'),
            'create' => Pages\CreateMagazine::route('/create'),
            'edit' => Pages\EditMagazine::route('/{record}/edit'),
        ];
    }
}

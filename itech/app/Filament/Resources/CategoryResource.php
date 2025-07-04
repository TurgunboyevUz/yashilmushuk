<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Product\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $label = 'kategoriya';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Kategoriyalar';

    protected static ?string $pluralLabel = 'Kategoriyalar';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('parent_id')->label('Asosiy kategoriya')->options(function ($record){
                    return Category::where('id', '!=', $record?->id)->get()->pluck('name', 'id')->toArray();
                }),
                TextInput::make('name')->label('Nomi')->required()->unique(ignoreRecord: true),
                FileUpload::make('image_path')->label('Rasm')->directory('categories')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nomi')
                    ->formatStateUsing(fn(Category $record): string => $record->parent ? "{$record->name} (sub-kategoriya)" : $record->name)
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_path')->label('Rasm'),
                TextColumn::make('parent.name')->label('Asosiy kategoriya')->sortable()->searchable(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

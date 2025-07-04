<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Page\Image;
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

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $label = 'rasm';

    protected static ?string $navigationGroup = 'Sozlamalar';

    protected static ?string $navigationLabel = 'Rasmlar';

    protected static ?string $pluralLabel = 'Rasmlar';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('key')->label('Kalit')->options([
                    'logo' => 'Logo',
                    'loader' => 'Loader',
                    'about' => 'Biz haqimizda',
                    'slider' => 'Slider',
                ]),
                TextInput::make('name')->label('Nomi')->required(),
                TextInput::make('alt')->label('Boshlang\'ich nom')->required()->columnSpanFull(),
                FileUpload::make('path')->label('Rasm')->directory('images')->required()->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('key')->label('Kalit')->searchable(),
                TextColumn::make('name')->label('Nomi')->searchable(),
                TextColumn::make('alt')->label('Boshlang\'ich nom')->searchable(),
                ImageColumn::make('path')->label('Rasm')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Image $record) {
                        if($record->key == 'slider'){
                            return Image::where('key', 'slider')->count() > 1;
                        }

                        $non_visible = ['logo', 'loader', 'about'];

                        return !in_array($record->key, $non_visible);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('key', 'slider')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}

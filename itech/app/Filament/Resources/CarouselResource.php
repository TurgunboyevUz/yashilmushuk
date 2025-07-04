<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselResource\Pages;
use App\Filament\Resources\CarouselResource\RelationManagers;
use App\Models\Page\Carousel;
use App\Models\Page\Image;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarouselResource extends Resource
{
    protected static ?string $model = Carousel::class;

    protected static ?string $label = 'slayder';

    protected static ?string $navigationGroup = 'Sozlamalar';

    protected static ?string $navigationLabel = 'Slayder';

    protected static ?string $pluralLabel = 'Slayder';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('image_id')->label('Slayder')->options(Image::where('key', 'slider')->get()->pluck('name', 'id')->toArray())->required()->columnSpanFull(),
                Textarea::make('primary_text')->label('Asosiy matn')->required(),
                Textarea::make('secondary_text')->label('Qo\'shimcha matn'),
                TextInput::make('button_text')->label('Knopka matni')->requiredIfAccepted('button'),
                TextInput::make('button_url')->label('Knopka havolasi')->requiredIfAccepted('button')->url(),
                Toggle::make('button')->label('Knopka'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image.name')->label('Slayder')->sortable(),
                TextColumn::make('primary_text')->label('Asosiy matn')->sortable(),
                TextColumn::make('secondary_text')->label('Qo\'shimcha matn')->sortable(),
                TextColumn::make('button_text')->label('Knopka matni')->sortable(),
                TextColumn::make('button_url')->label('Knopka havolasi')->sortable(),
                ToggleColumn::make('button')->label('Knopka'),
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
            'index' => Pages\ListCarousels::route('/'),
            'create' => Pages\CreateCarousel::route('/create'),
            'edit' => Pages\EditCarousel::route('/{record}/edit'),
        ];
    }
}

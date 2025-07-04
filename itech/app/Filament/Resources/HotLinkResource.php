<?php
namespace App\Filament\Resources;

use App\Filament\Resources\HotLinkResource\Pages;
use App\Models\Page\HotLink;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HotLinkResource extends Resource
{
    protected static ?string $model = HotLink::class;

    protected static ?string $label = 'qaynoq havola';

    protected static ?string $navigationGroup = 'Sozlamalar';

    protected static ?string $navigationLabel = 'Qaynoq havolalar';

    protected static ?string $pluralLabel = 'Qaynoq havolalar';

    protected static ?string $navigationBadgeTooltip = 'Qaynoq havolalar soni';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label("Nomi")->required()->unique(ignoreRecord: true),
                TextInput::make('url')->label("Havola")->url()->required()->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label("Nomi"),
                TextColumn::make('url')->label("Havola"),
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

    public static function getNavigationBadgeColor(): string|array|null
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
            'index'  => Pages\ListHotLinks::route('/'),
            'create' => Pages\CreateHotLink::route('/create'),
            'edit'   => Pages\EditHotLink::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        if(self::getModel()::count() > 5){
            return false;
        }else{
            return true;
        }
    }
}

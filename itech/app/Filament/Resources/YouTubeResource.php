<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YouTubeResource\Pages;
use App\Filament\Resources\YouTubeResource\RelationManagers;
use App\Models\Page\YouTube;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YouTubeResource extends Resource
{
    protected static ?string $model = YouTube::class;

    protected static ?string $label = 'youtube yangiligi';

    protected static ?string $navigationGroup = 'Sozlamalar';

    protected static ?string $navigationLabel = 'YouTube yangiliklar';

    protected static ?string $pluralLabel = 'YouTube yangiliklar';

    protected static ?string $navigationBadgeTooltip = 'YouTube havolalari';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?int $navigationSort = 7; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Nomi')->required()->unique(ignoreRecord: true),
                TextInput::make('url')->label('Havola')->required()->url()->unique(ignoreRecord: true),
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
            'index' => Pages\ListYouTubes::route('/'),
            'create' => Pages\CreateYouTube::route('/create'),
            'edit' => Pages\EditYouTube::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        if(self::getModel()::count() > 9){
            return false;
        }else{
            return true;
        }
    }
}

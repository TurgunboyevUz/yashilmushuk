<?php

namespace Filament\Resources;

use App\Models\YouTube;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\YouTubeResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class YouTubeResource extends Resource
{
    protected static ?string $model = YouTube::class;

    protected static ?string $label = 'havola';

    protected static ?string $pluralLabel = 'havolalar';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Ijtimoiy tarmoqlar';

    protected static ?string $navigationLabel = 'YouTube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nomi')
                    ->required()
                    ->maxLength(255),

                TextInput::make('url')
                    ->label('Havola')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('url')
                    ->searchable(),

                ToggleColumn::make('status')
                    ->label('Status'),

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
                Tables\Actions\DeleteAction::make()->hidden(function (YouTube $record) {
                    $keys = ['main-1', 'main-2', 'about'];

                    return in_array($record->key, $keys);
                }),
            ])
            ->bulkActions([
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
            'index' => Pages\ListYouTubes::route('/'),
            'create' => Pages\CreateYouTube::route('/create'),
            'view' => Pages\ViewYouTube::route('/{record}'),
            'edit' => Pages\EditYouTube::route('/{record}/edit'),
        ];
    }
}

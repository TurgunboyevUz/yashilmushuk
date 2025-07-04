<?php

namespace Filament\Resources;

use App\Models\Social;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\SocialResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static ?string $label = 'tarmoq';

    protected static ?string $pluralLabel = 'tarmoqlar';

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?string $navigationGroup = 'Ijtimoiy tarmoqlar';

    protected static ?string $navigationLabel = 'Ijtimoiy tarmoqlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nomi')
                    ->required()
                    ->maxLength(255),
                TextInput::make('key')
                    ->label('Kalit')
                    ->required()
                    ->maxLength(255),

                TextInput::make('icon')
                    ->label('Ikonka')
                    ->maxLength(255)->disabled(),
                ColorPicker::make('color')
                    ->label('Rang')->disabled(),

                TextInput::make('value')
                    ->label('Qiymat')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nomi')
                    ->searchable(),

                TextColumn::make('key')->label('Kalit')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('value')->label('Qiymat')
                    ->searchable(),

                TextColumn::make('icon')->label('Ikonka')
                    ->placeholder('Ikonka yo\'q')
                    ->searchable(),

                ColorColumn::make('color')->label('Rang')
                    ->placeholder('Rang yo\'q')
                    ->searchable(),

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
            'index' => Pages\ListSocials::route('/'),
            'create' => Pages\CreateSocial::route('/create'),
            'view' => Pages\ViewSocial::route('/{record}'),
            'edit' => Pages\EditSocial::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

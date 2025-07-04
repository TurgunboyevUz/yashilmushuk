<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Bonus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\BonusResource\Pages;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BonusResource extends Resource
{
    use Translatable;

    protected static ?string $model = Bonus::class;

    protected static ?string $label = 'bonus';

    protected static ?string $pluralLabel = 'bonuslar';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Ommaviy';

    protected static ?string $navigationLabel = 'Bonus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make('Bonus')->schema([
                    TextInput::make('name')
                        ->label('Nomi')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('description')
                        ->label('Qisqa tavsif')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                FileUpload::make('image')
                    ->directory('bonuses')
                    ->label('Rasm')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nomi')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('description')->label('Qisqa tavsif')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->limit(50),

                ImageColumn::make('image')
                    ->label('Rasm'),

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
            'index' => Pages\ListBonuses::route('/'),
            'create' => Pages\CreateBonus::route('/create'),
            'view' => Pages\ViewBonus::route('/{record}'),
            'edit' => Pages\EditBonus::route('/{record}/edit'),
        ];
    }
}

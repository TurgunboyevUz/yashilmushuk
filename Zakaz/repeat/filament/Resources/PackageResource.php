<?php

namespace Filament\Resources;

use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\PackageResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $label = 'paket';

    protected static ?string $pluralLabel = 'Paketlar';

    protected static ?string $navigationGroup = 'Iqtisod';

    protected static ?string $navigationLabel = 'Paketlar';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Paket haqida')->columnSpan(1)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nomi')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Tavsif')
                        ->columnSpanFull()
                        ->rows(4),

                    Forms\Components\FileUpload::make('image')
                        ->directory('packages')
                        ->label('Rasm')
                        ->columnSpanFull()
                        ->image()
                        ->imageEditor()
                        ->panelLayout('grid'),
                ]),

                Fieldset::make('Narx va tangalar')->columnSpan(1)->schema([
                    Forms\Components\TextInput::make('price')
                        ->label('Narx')
                        ->required()
                        ->numeric()
                        ->suffix('UZS'),
                    Forms\Components\TextInput::make('coins')
                        ->label('Tangalar')
                        ->required()
                        ->numeric(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nomi')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image')
                    ->placeholder('Mavjud emas')
                    ->label('Rasm'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Narx')
                    ->formatStateUsing(fn (string $state): string => number_format($state, thousands_separator: ' '))
                    ->suffix(' UZS')
                    ->sortable(),

                Tables\Columns\TextColumn::make('coins')
                    ->label('Tangalar')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

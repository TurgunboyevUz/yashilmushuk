<?php

namespace Filament\Resources;

use Filament\Resources\InstrumentResource\Pages;
use Filament\Resources\InstrumentResource\RelationManagers;
use App\Models\Instrument;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?string $label = 'instrument';

    protected static ?string $pluralLabel = 'Instrumentlar';

    protected static ?string $navigationLabel = 'Instrumentlar';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('name')
                        ->label('Nomi')
                        ->required()
                        ->maxLength(255),

                    Select::make('unit_id')
                        ->label('Birligi')
                        ->options(Unit::select(DB::raw('CONCAT(name, " (", short_code, ")") AS name'), 'id')->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false),

                    TextInput::make('price')
                        ->label('Narxi')
                        ->required()
                        ->numeric()
                        ->suffix('UZS'),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    Textarea::make('description')
                        ->label('Qisqacha izoh')
                        ->rows(3),

                    FileUpload::make('image')
                        ->label('Rasmi')
                        ->directory('products')
                        ->image()
                        ->panelLayout('grid'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
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
            'index' => Pages\ListInstruments::route('/'),
            'create' => Pages\CreateInstrument::route('/create'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

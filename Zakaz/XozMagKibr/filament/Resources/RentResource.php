<?php

namespace Filament\Resources;

use App\Models\Instrument;
use Filament\Resources\RentResource\Pages;
use Filament\Resources\RentResource\RelationManagers;
use App\Models\Rent;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class RentResource extends Resource
{
    protected static ?string $model = Rent::class;

    protected static ?string $label = 'ijara';

    protected static ?string $pluralLabel = 'Ijaralar';

    protected static ?string $navigationLabel = 'Ijaralar';

    protected static ?string $navigationGroup = 'Iqtisod';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('name')->label('Kimga')->required()->maxLength(255),

                    TextInput::make('phone')->label('Telefon raqami')->prefix('+998')->required()->maxLength(255),

                    Select::make('instrument_id')
                        ->label('Instrument')
                        ->options(Instrument::all()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(function ($get, $set) {
                            $set('unit_id', Instrument::find($get('instrument_id'))->unit_id);
                        })
                        ->required(),

                    Select::make('unit_id')
                        ->label('Birligi')
                        ->options(Unit::select(DB::raw('CONCAT(name, " (", short_code, ")") AS name'), 'id')->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('quantity')
                        ->label('Miqdori')
                        ->required()
                        ->numeric()
                        ->live()
                        ->afterStateUpdated(function ($get, $set) {
                            $set('total_price', (int) $get('quantity') * (int) Instrument::find($get('instrument_id'))->price);
                        }),

                    TextInput::make('total_price')
                        ->label('Umumiy narxi')
                        ->default(0)
                        ->required()
                        ->numeric(),

                    Textarea::make('description')
                        ->label('Qisqacha izoh')
                        ->rows(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instrument.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->prefix('+998')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('UZS', locale: 'uz')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->boolean(),

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
                Action::make('status_true')
                    ->icon('heroicon-s-check')
                    ->color('success')
                    ->label('Qaytarildi')
                    ->action(function (Rent $record) {
                        $record->status = !$record->status;
                        $record->save();
                    })
                    ->visible(fn (Rent $record): bool => $record->status == false),

                Action::make('status_false')
                    ->icon('heroicon-s-x-mark')
                    ->color('danger')
                    ->label('Qaytarilmadi')
                    ->action(function (Rent $record) {
                        $record->status = !$record->status;
                        $record->save();
                    })
                    ->visible(fn (Rent $record): bool => $record->status == true),

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
            'index' => Pages\ListRents::route('/'),
            'create' => Pages\CreateRent::route('/create'),
            'edit' => Pages\EditRent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', false)->count();
    }
}

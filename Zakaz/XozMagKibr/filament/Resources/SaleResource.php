<?php
namespace Filament\Resources;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Unit;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\SaleResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $label = 'sotuv';

    protected static ?string $pluralLabel = 'Sotuvlar';

    protected static ?string $navigationLabel = 'Sotuvlar';

    protected static ?string $navigationGroup = 'Iqtisod';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    Select::make('product_id')
                        ->label('Mahsulot')
                        ->options(Product::all()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(function ($get, $set) {
                            $set('unit_id', Product::find($get('product_id'))->unit_id);
                        })
                        ->required(),

                    Select::make('unit_id')
                        ->label('Birligi')
                        ->options(Unit::select(DB::raw('CONCAT(name, " (", short_code, ")") AS name'), 'id')->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false),

                    Textarea::make('description')
                        ->label('Qisqacha izoh')
                        ->rows(3),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('quantity')
                        ->label('Miqdori')
                        ->required()
                        ->numeric()
                        ->live()
                        ->afterStateUpdated(function ($get, $set) {
                            $set('total_price', (int) $get('quantity') * (int) Product::find($get('product_id'))->price);
                        }),

                    TextInput::make('total_price')
                        ->label('Umumiy narxi')
                        ->default(0)
                        ->required()
                        ->numeric(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Mahsulot')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Birligi')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Miqdori')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Umumiy narxi')
                    ->money('UZS', locale: 'uz')
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
            'index'  => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit'   => Pages\EditSale::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

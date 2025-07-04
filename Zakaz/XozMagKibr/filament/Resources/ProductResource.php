<?php
namespace Filament\Resources;

use App\Models\Product;
use App\Models\Unit;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\ProductResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $label = 'mahsulot';

    protected static ?string $pluralLabel = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Mahsulotlar';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nomi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Birligi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->placeholder('Mavjud emas')
                    ->label('Qisqacha izoh')
                    ->limit(50)
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image')
                    ->placeholder('Mavjud emas')
                    ->label('Rasmi'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Narxi')
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

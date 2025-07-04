<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\ProductResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $label = 'mahsulot';

    protected static ?string $pluralLabel = 'mahsulotlar';

    protected static ?string $navigationIcon = 'heroicon-o-scissors';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Mahsulotlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(null)->schema([
                    Select::make('catalog_id')
                        ->label('Katalog')
                        ->options(Catalog::all()->pluck('name', 'id')->toArray())
                        ->native(false)->preload()->searchable()->live()
                        ->afterStateUpdated(fn (Set $set) => $set('category_id', null)),

                    Select::make('category_id')
                        ->label('Kategoriya')
                        ->options(fn (Get $get) => Category::where('catalog_id', $get('catalog_id'))->pluck('name', 'id'))
                        ->native(false)->preload()->searchable()->live()->required(),
                ])->columnSpan(1),

                Section::make("Tugma ma'lumotlari")->schema([
                    TextInput::make('custom_url')->label('Tugma havolasi'),
                    Toggle::make('is_available')->label('Mavjud')->default(1),
                ])->columnSpan(1),

                Section::make(null)->schema([
                    FileUpload::make('images')
                        ->label('Rasmlar')
                        ->directory('products')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('200')
                        ->panelLayout('grid')
                        ->maxFiles(12)
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpan(1),

                TranslatableTabs::make('Mahsulot')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nomi')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('color')
                            ->required()
                            ->label('Ranglari')
                            ->columnSpanFull(),

                        Textarea::make('custom_text')
                            ->label('Tugma teksti')
                            ->extraAttributes([
                                'style' => 'height: 130px;',
                            ]),
                    ])->columnSpan(2),

                Section::make("Qo'shimcha ma'lumotlar")->schema([
                    TextInput::make('price')
                        ->label('Narx')
                        ->numeric()
                        ->suffix('UZS'),

                    TextInput::make('size')
                        ->required()
                        ->label('O\'lcham')
                        ->maxLength(255),

                    TextInput::make('code')
                        ->required()
                        ->label('Artikul')
                        ->maxLength(255),

                    TagsInput::make('brands')
                        ->label('Brendlar')
                        ->color('primary')
                        ->placeholder('Brend nomi')
                        ->splitKeys(['Tab', ','])
                        ->reorderable(),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->label('Kategoriya')->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')->label('Nomi')->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->placeholder('Narx belgilanmagan')
                    ->label('Narx')
                    ->money('UZS')
                    ->sortable(),

                TextColumn::make('size')
                    ->placeholder('O\'lcham belgilanmagan')
                    ->label('O\'lcham')
                    ->searchable(),

                TextColumn::make('code')
                    ->placeholder('Mavjud emas')
                    ->label('Artikul')
                    ->searchable(),

                ImageColumn::make('images')->label('Rasmlar')
                    ->toggleable(),

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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

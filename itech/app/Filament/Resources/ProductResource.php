<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product\Category;
use App\Models\Product\Color;
use App\Models\Product\Product;
use App\Models\Product\Size;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $label = 'mahsulot';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Mahsulotlar';

    protected static ?string $pluralLabel = 'Mahsulotlar';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        $categories = Category::with('parent', 'children')->get();
        $categories = $categories->mapWithKeys(function ($category) {
            if ($category->parent_id === null && $category->children->isNotEmpty()) {
                return [];
            } elseif ($category->parent_id !== null) {
                return [$category->id => $category->name . ' (' . $category->parent->name . ')'];
            } else {
                return [$category->id => $category->name];
            }
        })->toArray();

        $product = Step::make('Mahsulot')
            ->description("Mahsulot ma'lumotlarini kiritish")
            ->schema([
                Select::make('category_id')->label('Kategoriya')->required()->options($categories),
                TextInput::make('name')->label('Nomi')->required(),
                Textarea::make('description')->label('Tavsif')->required(),
                FileUpload::make('image_path')->label('Rasm')->directory('products')->required()->multiple(),

                Toggle::make('telegram')->label('Telegram orqali yuborish')->hiddenOn(['edit', 'view']),
            ]);

        $sizes = Step::make('O\'lchov birligi')
            ->description("O'lchov birliklarini tanlash")
            ->schema([
                Repeater::make('sizes')->label('O\'lchov birligi')->schema([
                    Select::make('size_id')->label('O\'lchov birligi')->options(Size::all()->pluck('name', 'id')->toArray()),
                    TextInput::make('price')->label('Narxi')->numeric()->suffix('UZS'),
                ])->defaultItems(0)->relationship('prices'),
            ]);

        $colors = Step::make('Ranglar')
            ->description("Ranglarni tanlash")
            ->schema([
                CheckboxList::make('colors')->label('Ranglar')->options(Color::all()->pluck('name', 'id')->toArray())->required(),
            ]);

        return $form->schema([
            Wizard::make([$product, $sizes, $colors])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->label('Kategoriya')->formatStateUsing(fn(Product $record): string => $record->category->parent ? "{$record->category->name} ({$record->category->parent->name})" : $record->category->name),
                TextColumn::make('name')->label('Nomi'),
                TextColumn::make('description')->label('Tavsif')->words(5),
                ImageColumn::make('image_path')->label('Rasm'),
                TextColumn::make('prices')
                    ->label('Narx va o\'lcham')
                    ->getStateUsing(function ($record) {
                        $data = [];

                        if($record->prices->isEmpty()) {
                            $data[] = 'Narx belgilanmagan';

                            return $data;
                        }

                        foreach ($record->prices as $product) {
                            $content = '';

                            if (isset($product->size)) {
                                $content = $product->size->name;
                            }

                            if (isset($product->price)) {
                                $price = number_format(floatval($product->price), 0, ',', '.');

                                if (isset($product->size)) {
                                    $content .= ' (' . $price . ' so\'m)';
                                } else {
                                    $content = $price . ' so\'m';
                                }
                            } else {
                                if (isset($product->size)) {
                                    $content .= ' (narxsiz)';
                                } else {
                                    $content = 'Narx belgilanmagan';
                                }
                            }

                            $data[] = $content;
                        }

                        return $data;
                    })
                    ->listWithLineBreaks()
                    ->badge(),

                TextColumn::make('colors')
                    ->label('Ranglar')
                    ->getStateUsing(function ($record) {
                        return collect($record->colors)
                            ->map(fn($id) => Color::find($id)?->name)
                            ->filter()
                            ->join(', ');
                    })->badge(),
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

    public static function getBreadcrumb(): string
    {
        return self::$navigationLabel;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

}

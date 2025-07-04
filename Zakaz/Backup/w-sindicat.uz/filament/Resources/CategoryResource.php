<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Catalog;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\CategoryResource\Pages;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Category::class;

    protected static ?string $label = 'kategoriya';

    protected static ?string $pluralLabel = 'kategoriyalar';

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static ?string $navigationGroup = 'Mahsulotlar';

    protected static ?string $navigationLabel = 'Kategoriyalar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('catalog_id')
                    ->label('Katalog')
                    ->options(Catalog::all()->pluck('name', 'id')->toArray())
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->required(),

                TranslatableTabs::make('Kategoriya')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nomi')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Qisqa tavsif')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('catalog.name')
                    ->label('Katalog')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nomi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Qisqa tavsif')
                    ->searchable()
                    ->sortable()->limit(50),

                TextColumn::make('url')
                    ->label('Kategoriya URL')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kategoriya havolasi buferga saqlandi')
                    ->getStateUsing(fn (Category $record): string => route('product', ['catalog' => $record->catalog->slug, 'slug' => $record->slug]))
                    ->toggleable(isToggledHiddenByDefault: true),

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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

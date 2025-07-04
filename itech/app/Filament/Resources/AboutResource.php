<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\Page\About;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $label = 'biz haqimizda';

    protected static ?string $navigationGroup = 'Sozlamalar';

    protected static ?string $navigationLabel = 'Biz haqimizda';

    protected static ?string $pluralLabel = 'Biz haqimizda';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')->label('Nomi')->required(),
                Select::make('key')->label('Kalit')->options([
                    'additional' => 'Qo\'shimcha ma\'lumot',
                ])->native(false)->required()->live(),

                MarkdownEditor::make('value')->label('Qiymat')->required()->columnSpanFull()->visible(fn (?About $record, Get $get) => $record?->key === 'additional' || $get('key') === 'additional')->columnSpanFull(),
                TextInput::make('value')->label('Qiymat')->required()->visible(fn (?About $record, Get $get) => $record?->key !== 'additional' && $get('key') !== 'additional')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->toggleable(),
                TextColumn::make('label')->label('Nomi')->sortable()->toggleable(),
                TextColumn::make('key')->label('Kalit')->sortable()->toggleable(),
                TextColumn::make('value')->label('Qiymat')->sortable()->toggleable()->words(8)->limit(40),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->visible(function (About $record) {
                    return $record->key == 'additional';
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultPaginationPageOption('all');
    }

    public static function getBreadcrumb(): string
    {
        return self::$navigationLabel;
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}

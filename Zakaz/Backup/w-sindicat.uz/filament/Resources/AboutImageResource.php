<?php

namespace Filament\Resources;

use App\Models\AboutImage;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\AboutImageResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;

class AboutImageResource extends Resource
{
    protected static ?string $model = AboutImage::class;

    protected static ?string $label = 'rasm';

    protected static ?string $pluralLabel = 'rasmlar';

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = 'Ommaviy';

    protected static ?string $navigationLabel = 'Biz haqimizda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(null)->schema([
                    Select::make('type')
                        ->label('Rasm turi')
                        ->options([
                            'fabric' => 'Fabrika haqida',
                            'equipment' => 'Uskunalar',
                        ])
                        ->required()
                        ->native(false)
                        ->preload(),

                    Forms\Components\FileUpload::make('image')
                        ->directory('abouts')
                        ->label('Rasm')
                        ->panelLayout('grid')
                        ->image()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Rasm turi')
                    ->formatStateUsing(function ($state) {
                        return [
                            'fabric' => 'Fabrika haqida',
                            'equipment' => 'Uskunalar',
                        ][$state];
                    })
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Rasm'),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAboutImages::route('/'),
            'create' => Pages\CreateAboutImage::route('/create'),
            'edit' => Pages\EditAboutImage::route('/{record}/edit'),
        ];
    }
}

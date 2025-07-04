<?php

namespace Filament\Resources;

use App\Models\Support;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\SupportResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;

class SupportResource extends Resource
{
    protected static ?string $model = Support::class;

    protected static ?string $label = 'qo\'llab-quvvatlash';

    protected static ?string $pluralLabel = 'Qo\'llab-quvvatlash';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = "Qo'llab-quvvatlash";

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Qo\'llab-quvvatlash')->schema([
                    Grid::make(1)->columnSpan(1)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nomi')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Turi')
                            ->options([
                                'contact' => 'Telefon raqam',
                                'username' => 'Username',
                            ])
                            ->default('contact')
                            ->native(false)
                            ->required()
                            ->live(),
                    ]),

                    Forms\Components\TextInput::make('value')
                        ->label('Qiymat')
                        ->required()
                        ->maxLength(255)
                        ->prefix(fn ($get) => $get('type') == 'contact' ? ' +998' : '@'),
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

                Tables\Columns\TextColumn::make('type')
                    ->label('Turi'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Qiymati')
                    ->searchable(),
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
            'index' => Pages\ListSupports::route('/'),
            'create' => Pages\CreateSupport::route('/create'),
            'edit' => Pages\EditSupport::route('/{record}/edit'),
        ];
    }
}

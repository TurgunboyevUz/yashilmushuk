<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TelegramResource\Pages;
use App\Filament\Resources\TelegramResource\RelationManagers;
use App\Models\Telegram;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TelegramResource extends Resource
{
    protected static ?string $model = Telegram::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Telegram';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
                TextInput::make('phone')
                    ->prefix('+')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('api_id')
                    ->required()
                    ->maxLength(255),
                TextInput::make('api_hash')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('api_id')
                    ->searchable(),
                TextColumn::make('api_hash')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),

                TextColumn::make('active')
                    ->formatStateUsing(function (int $state): string {
                        if($state == 0){
                            return 'Inactive';
                        }elseif($state == 1){
                            return 'Active';
                        }else{
                            return 'Spammed';
                        }
                    })
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        0 => 'primary',
                        1 => 'success',
                        2 => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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

                Action::make('login')
                    ->label('Login')
                    ->url(fn(Telegram $record): string => route('login', ['id' => $record->id]), true)
                    ->hidden(fn(Telegram $record): bool => $record->active != 0)
                    ->icon('heroicon-s-arrow-top-right-on-square')
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
            'index' => Pages\ListTelegrams::route('/'),
            'create' => Pages\CreateTelegram::route('/create'),
            'view' => Pages\ViewTelegram::route('/{record}'),
            'edit' => Pages\EditTelegram::route('/{record}/edit'),
        ];
    }
}

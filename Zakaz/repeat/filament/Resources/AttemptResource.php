<?php

namespace Filament\Resources;

use Filament\Resources\AttemptResource\Pages;
use Filament\Resources\AttemptResource\RelationManagers;
use App\Models\Attempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\AttemptResource\RelationManagers\AnswersRelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttemptResource extends Resource
{
    protected static ?string $model = Attempt::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Urinishlar';

    protected static ?string $label = 'urinish';

    protected static ?string $pluralLabel = 'Urinishlar';

    protected static ?string $navigationLabel = 'Foydalanuvchi urinishlari';

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('userExam.user.name')->label('Foydalanuvchi')->sortable(),
                TextColumn::make('userExam.exam.title')->label('Imtihon nomi')->sortable(),
                TextColumn::make('userExam.exam.type')->label('Imtihon turi')->formatStateUsing(function ($state) {
                    return $state == 'speaking' ? "Speaking" : "Writing";
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            AnswersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttempts::route('/'),
            'create' => Pages\CreateAttempt::route('/create'),
            'edit' => Pages\EditAttempt::route('/{record}/edit'),
            'view' => Pages\ViewAttempt::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}

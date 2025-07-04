<?php
namespace Filament\Resources;

use App\Models\Debt;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\DebtResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class DebtResource extends Resource
{
    protected static ?string $model = Debt::class;

    protected static ?string $label = 'qarz';

    protected static ?string $pluralLabel = 'Qarzlar';

    protected static ?string $navigationLabel = 'Qarzlar';

    protected static ?string $navigationGroup = 'Iqtisod';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('name')
                        ->label('Kimga')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->label('Tel raqami')
                        ->prefix('+998')
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('amount')
                        ->label('Summa')
                        ->required()
                        ->numeric(),
                ]),

                Textarea::make('description')
                    ->label('Qisqacha izoh')
                    ->maxLength(255)
                    ->rows(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kimga')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->placeholder('Mavjud emas')
                    ->label('Qisqacha izoh')
                    ->limit(50),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Tel raqami')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Summa')
                    ->money('UZS', locale: 'uz')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                    
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
                Action::make('status_true')
                    ->icon('heroicon-s-check')
                    ->color('success')
                    ->label('Qaytarildi')
                    ->action(function (Debt $record) {
                        $record->status = !$record->status;
                        $record->save();
                    })
                    ->visible(fn (Debt $record): bool => $record->status == false),

                Action::make('status_false')
                    ->icon('heroicon-s-x-mark')
                    ->color('danger')
                    ->label('Qaytarilmadi')
                    ->action(function (Debt $record) {
                        $record->status = !$record->status;
                        $record->save();
                    })
                    ->visible(fn (Debt $record): bool => $record->status == true),
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
            'index'  => Pages\ListDebts::route('/'),
            'create' => Pages\CreateDebt::route('/create'),
            'edit'   => Pages\EditDebt::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', false)->count();
    }
}

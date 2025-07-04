<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\FAQ;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\FAQResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FAQResource extends Resource
{
    use Translatable;

    protected static ?string $model = FAQ::class;

    protected static ?string $label = 'savol';

    protected static ?string $pluralLabel = 'savollar';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Ommaviy';

    protected static ?string $navigationLabel = 'Savol va javoblar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make('Savol va javob')->schema([
                    Textarea::make('question')->label('Savol')
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('answer')->label('Javob')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->label('Savol')
                    ->searchable()->limit(50),

                TextColumn::make('answer')->label('Javob')
                    ->searchable()->limit(50),

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
            'index' => Pages\ListFAQS::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'view' => Pages\ViewFAQ::route('/{record}'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}

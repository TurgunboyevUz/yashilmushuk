<?php

namespace Filament\Resources;

use App\Models\Promocode;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\PromocodeResource\Pages;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PromocodeResource extends Resource
{
    protected static ?string $model = Promocode::class;

    protected static ?string $label = 'promokod';

    protected static ?string $pluralLabel = 'Promokodlar';

    protected static ?string $navigationGroup = 'Iqtisod';

    protected static ?string $navigationLabel = 'Promokodlar';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Promokod ma\'lumotlari')
                    // ->description('Enter the main details for the promo code.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('code')
                            ->label('Promokod')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('masalan: YOZ20')
                            ->live()
                            ->afterStateUpdated(fn ($set, $state) => $set('code', strtoupper($state)))
                            ->suffixAction(
                                Action::make('generate')
                                    ->label('')
                                    ->icon('heroicon-o-squares-plus')
                                    ->action(function ($set) {
                                        do {
                                            $code = strtoupper(Str::random(8));
                                        } while (Promocode::where('code', $code)->exists());

                                        return $set('code', $code);
                                    })
                            ),

                        Select::make('exam_id')
                            ->relationship('exam', 'title') // Assuming 'exam' is a relationship
                            ->nullable()
                            ->searchable()
                            ->preload()
                            ->label('Imtihonni tanlang')
                            ->placeholder('Imtihonni tanlang')
                            ->helperText("Agar bo'sh bo'lsa, promokod barcha imtihonlar uchun amal qiladi"),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Promokod nomi')
                            ->placeholder('e.g., Yoz uchun 20% chegirma'),

                        Textarea::make('description')
                            ->nullable()
                            ->columnSpanFull() // Takes full width in a multi-column section
                            ->label('Tavsif')
                            ->placeholder('masalan: Ushbu yoz uchun barcha kurslarga 20% chegirma oling!')
                            ->rows(3),
                    ])
                    ->columns(2)     // Two columns for better layout
                    ->collapsible(), // Make the section collapsible

                Section::make('Chegirma sozlamalari')
                    // ->description('Chegirma turi va miqdorini belgilang')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Radio::make('discount_type')
                            ->options([
                                'percentage' => 'Foiz (%)',
                                'fixed_amount' => 'Miqdor (so‘m & tanga)',
                            ])
                            ->required()
                            ->default('percentage')
                            ->inline()
                            ->label('Chegirma turi')
                            ->live(),

                        Grid::make(1)->columnSpan(1)->schema([
                            TextInput::make('discount_percentage')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->suffix('%')
                                ->label('Chegirma foizi (%)')
                                ->placeholder('e.g., 20')
                                ->visible(fn ($get) => $get('discount_type') === 'percentage')
                                ->required(fn ($get) => $get('discount_type') === 'percentage'),

                            TextInput::make('discount_uzs')
                                ->numeric()
                                ->minValue(0)
                                ->suffix('UZS')
                                ->label('Chegirma miqdori (UZS)')
                                ->placeholder('e.g., 50000')
                                ->visible(fn ($get) => $get('discount_type') === 'fixed_amount')
                                ->required(fn ($get) => $get('discount_type') === 'fixed_amount'),

                            TextInput::make('discount_coin')
                                ->numeric()
                                ->minValue(0)
                                ->suffix('Coins')
                                ->label('Chegirma miqdori (tanga)')
                                ->placeholder('e.g., 100')
                                ->visible(fn ($get) => $get('discount_type') === 'fixed_amount')
                                ->required(fn ($get) => $get('discount_type') === 'fixed_amount'),
                        ]),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Foydalanish va vaqtlar')
                    // ->description('Promokod uchun foydalanish miqdori va vaqtlarini belgilang')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        TextInput::make('usage_limit')
                            ->numeric()
                            ->minValue(1)
                            ->nullable()
                            ->label('Foydalanish limiti')
                            ->placeholder('masalan: 100'),

                        Grid::make(1)->columnSpan(1)->schema([
                            DatePicker::make('valid_from')
                                ->label('Sanadan')
                                ->placeholder('Sanani belgilang')
                                ->native(false)
                                ->default(now()),

                            DatePicker::make('valid_until')
                                ->label('Sanagacha')
                                ->placeholder('Sanani belgilang')
                                ->native(false),
                        ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exam.title')
                    ->label('Applies to Exam')
                    ->placeholder('All Exams') // Show 'All Exams' if exam_id is null
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)) // Capitalize first letter
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'info',
                        'fixed_amount' => 'success',
                    }),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Discount (%)')
                    ->suffix('%')
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
                Tables\Columns\TextColumn::make('discount_uzs')
                    ->label('Discount (UZS)')
                    ->money('UZS', 2)                             // Format as currency
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
                Tables\Columns\TextColumn::make('discount_coin')
                    ->label('Discount (Coins)')
                    ->suffix(' Coins')
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
                Tables\Columns\TextColumn::make('usage_limit')
                    ->label('Usage Limit')
                    ->formatStateUsing(fn (?int $state) => $state === null ? 'Unlimited' : (string) $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('used_count')
                    ->label('Used')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
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
                Tables\Filters\SelectFilter::make('discount_type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed_amount' => 'Fixed Amount',
                    ])
                    ->label('Discount Type'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->placeholder('All')
                    ->native(false),
                Tables\Filters\Filter::make('valid_period')
                    ->form([
                        DatePicker::make('valid_from_filter')
                            ->placeholder('Valid From (after)'),
                        DatePicker::make('valid_until_filter')
                            ->placeholder('Valid Until (before)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['valid_from_filter'],
                                fn (Builder $query, $date): Builder => $query->whereDate('valid_from', '>=', $date),
                            )
                            ->when(
                                $data['valid_until_filter'],
                                fn (Builder $query, $date): Builder => $query->whereDate('valid_until', '<=', $date),
                            );
                    }),
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
            'index' => Pages\ListPromocodes::route('/'),
            'create' => Pages\CreatePromocode::route('/create'),
            'edit' => Pages\EditPromocode::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'title', 'description'];
    }
}

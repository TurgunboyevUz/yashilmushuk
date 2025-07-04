<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\ServiceResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    use Translatable;

    protected static ?string $model = Service::class;

    protected static ?string $label = 'xizmat';

    protected static ?string $pluralLabel = 'xizmatlar';

    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';

    protected static ?string $navigationGroup = 'Ommaviy';

    protected static ?string $navigationLabel = 'Xizmatlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make('Sahifa')->schema([
                    TextInput::make('name')->label('Xizmat nomi')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('title')->label('Banner sarlavhasi')
                        ->required()
                        ->columnSpanFull(),

                    RichEditor::make('body')->label('Post')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Rasm')
                    ->directory('services')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Xizmat nomi')->limit(50),

                TextColumn::make('title')->label('Sarlavha')->limit(50),

                TextColumn::make('body')->label('Post')->limit(50)
                    ->formatStateUsing(fn (Service $record): string => strip_tags($record->body)),

                TextColumn::make('url')->label('Xizmat URL')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Xizmat havolasi buferga saqlandi')
                    ->getStateUsing(fn (Service $record): string => route('services.show', ['slug' => $record->slug]))
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('image'),

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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}

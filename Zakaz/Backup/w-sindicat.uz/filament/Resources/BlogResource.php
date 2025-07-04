<?php

namespace Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Blog;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\BlogResource\Pages;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BlogResource extends Resource
{
    use Translatable;

    protected static ?string $model = Blog::class;

    protected static ?string $label = 'post';

    protected static ?string $pluralLabel = 'postlar';

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationGroup = 'Ijtimoiy tarmoqlar';

    protected static ?string $navigationLabel = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make('Sahifa')->schema([
                    TextInput::make('title')
                        ->label('Sarlavha')
                        ->required(),
                    TextInput::make('subtitle')
                        ->label('Qisqa sarlavha')
                        ->required(),
                    RichEditor::make('body')
                        ->label('Post')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Rasm')
                    ->directory('blogs')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Sarlavha')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('subtitle')->label('Qisqa sarlavha')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('body')->label('Post')
                    ->html()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn (Blog $record): string => strip_tags($record->body))
                    ->limit(50),

                TextColumn::make('url')
                    ->label('Post URL')
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Post havolasi buferga saqlandi')
                    ->getStateUsing(fn (Blog $record): string => route('blog.show', ['slug' => $record->slug]))
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('image')->toggleable(),

                TextColumn::make('views')
                    ->label('Ko\'rishlar soni')
                    ->sortable()
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}

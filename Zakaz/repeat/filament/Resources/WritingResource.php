<?php

namespace Filament\Resources;

use App\Models\Category;
use App\Models\Exam;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\WritingResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WritingResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $label = 'writing';

    protected static ?string $pluralLabel = 'Writing';

    protected static ?string $navigationGroup = 'Imtihonlar';

    protected static ?string $navigationLabel = 'Writing';

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Imtihon ma'lumotlari")
                    ->schema([
                        Grid::make(1)->schema([
                            Hidden::make('type')->default('writing'),

                            TextInput::make('title')
                                ->required()
                                ->label('Nom')
                                ->maxLength(255),

                            Textarea::make('description')
                                ->label('Imtihon haqida')
                                ->rows(5),

                            FileUpload::make('image')
                                ->directory('exams')
                                ->image()
                                ->imageEditor()
                                ->required()
                                ->label('Rasm')
                                ->columnSpan(1)
                                ->panelLayout('grid'),
                        ])->columnSpan(1),

                        Grid::make(1)->columnSpan(1)->schema([
                            Select::make('price_type')->label('Narx turi')->default(0)->required()->native(false)->options([
                                1 => 'Bepul',
                                0 => 'Pullik',
                            ])->live(),

                            TextInput::make('price')->label("So'mda")->suffix('UZS')->numeric()->required()->hidden(fn($get) => $get('price_type') != 0),
                            TextInput::make('coins')->label('Tangada')->suffix('TM coin')->numeric()->required()->hidden(fn($get) => $get('price_type') != 0),
                        ]),
                    ])->columns(2),

                Repeater::make('part')->schema(self::writingPart())
                    ->itemLabel(fn ($state) => $state['name'] ?? null)
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible()
                    ->cloneable()
                    ->addAction(fn (Action $action) => $action->icon('heroicon-o-plus')->color('primary')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Nomi'),
                ImageColumn::make('image')->label('Rasmlar'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function(Builder $query){
                return $query->where('type', 'writing');
            });
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
            'index' => Pages\ListWritings::route('/'),
            'create' => Pages\CreateWriting::route('/create'),
            'edit' => Pages\EditWriting::route('/{record}/edit'),
        ];
    }

    public static function writingPart()
    {
        return [
            Grid::make(1)->columnSpan(1)->schema([
                TextInput::make('title')->required()->label('Nomi'),

                Textarea::make('description')->required()->label('Tavsif')->rows(5),

                FileUpload::make('images')
                    ->image()
                    ->imageEditor()
                    ->multiple()
                    ->directory('questions')
                    ->label('Rasm')
                    ->panelLayout('grid'),
            ]),

            Textarea::make('question')->label('Savollar')->required()->columnSpan(1)->rows(14),
        ];
    }
}

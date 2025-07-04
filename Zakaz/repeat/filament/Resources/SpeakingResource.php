<?php
namespace Filament\Resources;

use App\Models\Category;
use App\Models\Exam;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\SpeakingResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SpeakingResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $label = 'speaking';

    protected static ?string $pluralLabel = 'Speaking';

    protected static ?string $navigationGroup = 'Imtihonlar';

    protected static ?string $navigationLabel = 'Speaking';

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Imtihon ma'lumotlari")
                    ->schema([
                        Grid::make(1)->schema([
                            Hidden::make('type')->default('speaking'),

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

                Repeater::make('part')->schema(self::part())
                    ->itemLabel(fn($state) => $state['title'] ?? null)
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible()
                    ->cloneable()
                    ->addAction(fn(Action $action) => $action->icon('heroicon-o-plus')->color('primary')),
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
            ])->modifyQueryUsing(function (Builder $query) {
            return $query->where('type', 'speaking');
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
            'index'  => Pages\ListSpeakings::route('/'),
            'create' => Pages\CreateSpeaking::route('/create'),
            'edit'   => Pages\EditSpeaking::route('/{record}/edit'),
        ];
    }

    public static function part()
    {
        return [
            Section::make(null)->columnSpan(1)->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('title')->label('Nomi')->required()->live(true),

                    Select::make('question_type')->label('Savol turi')->native(false)->required()->options([
                        'question' => 'Savol',
                        'argument' => 'Argument',
                    ])->live(),
                ]),

                Textarea::make('description')->label('Part haqida')->rows(5),
            ]),

            Repeater::make('question')->label('Savollar')->schema(self::questions())
                ->columns(2)
                ->columnSpanFull()
                ->collapsible()
                ->cloneable()
                ->addAction(fn(Action $action) => $action->icon('heroicon-o-plus')->color('primary'))
                ->hidden(fn($get) => $get('question_type') == null),
        ];
    }

    public static function questions()
    {
        return [
            Repeater::make('question_list')->label('Savollar')->columns(2)->columnSpanFull()->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    Textarea::make('question')->label('Savol')->required(),
                    FileUpload::make('images')->label('Rasmlar')->directory('questions')->image()->multiple(),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('preparation_time')->label('Tayyorlanish vaqti')->default(5)->required(),
                    TextInput::make('answer_time')->label('Javob berish vaqti')->default(30)->required(),
                ]),
            ])
                ->hidden(fn($get) => $get('../../question_type') != 'question')
                ->disabled(fn($get) => $get('../../question_type') != 'question')
                ->collapsible()
                ->cloneable(),

            // -----------ARGUMENT SIDE---------------
            Group::make([
                FileUpload::make('images')
                    ->label('Rasmlar')
                    ->directory('questions')
                    ->image()
                    ->multiple()
                    ->columnSpan(1),

                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('preparation_time')
                            ->label('Tayyorlanish vaqti')
                            ->default(60)
                            ->required(),
                        TextInput::make('answer_time')
                            ->label('Javob berish vaqti')
                            ->default(120)
                            ->required(),
                    ]),

                Repeater::make('argument_list')
                    ->label('Argumentlar')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()->schema([
                            TextInput::make('value1')->label('Argument')->required(),
                            TextInput::make('value2')->label('Qarshi javob')->required(),
                        ]),
                    ])
                    ->defaultItems(3),
            ])
                ->visible(fn($get) => $get('../../question_type') === 'argument')
                ->columns(2)
                ->columnSpanFull(),
        ];
    }
}

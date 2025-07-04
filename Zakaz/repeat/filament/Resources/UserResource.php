<?php
namespace Filament\Resources;

use App\Models\Exam;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\UserResource\Pages;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'foydalanuvchi';

    protected static ?string $pluralLabel = 'Foydalanuvchilar';

    protected static ?string $navigationLabel = 'Foydalanuvchilar';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('name')->required()->label('Ismi'),
                    TextInput::make('email')->label('Email'),
                    TextInput::make('password')->password(),
                ]),

                TextInput::make('balance')->required()->label('Balans'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('telegram_id')->label('Telegram ID')->badge()->copyable(),
                TextColumn::make('name')->label('Ismi, familiyasi'),
                TextColumn::make('username')->label('Username')->placeholder('Username mavjud emas'),
                ImageColumn::make('photo_url')->label('Avatar rasmi')->circular()->placeholder('Avatar mavjud emas'),
                TextColumn::make('balance')->formatStateUsing(fn(string $state): string => number_format($state, thousands_separator: ' ')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('add_exam_action')
                    ->slideOver()
                    ->label('Imtihon qo\'shish')
                    ->icon('heroicon-o-plus')
                    ->color(Color::Green)
                    ->form([
                        Select::make('exam_id')
                            ->required()
                            ->preload()
                            ->native(false)
                            ->searchable()
                            ->label('Imtihonni tanlang:')
                            ->options(Exam::select(DB::raw("CONCAT(title, ' (', type, ')') as name"), 'id')->get()->pluck('name', 'id')),
                    ])
                    ->action(function ($record, array $data) {
                        $record->exams()->create($data);
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->visible(fn($record) => $record->telegram_id != null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->recordUrl(null);
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

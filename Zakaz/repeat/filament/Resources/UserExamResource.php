<?php
namespace Filament\Resources;

use App\Models\Exam;
use App\Models\User;
use App\Models\UserExam;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\UserExamResource\Pages;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UserExamResource extends Resource
{
    protected static ?string $model = UserExam::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'foydalanuvchi imtihoni';

    protected static ?string $pluralLabel = 'Foydalanuvchi imtihonlari';

    protected static ?string $navigationGroup = 'Urinishlar';

    protected static ?string $navigationLabel = 'Foydalanuvchi imtihonlari';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->native(false)
                    ->searchable()
                    ->label('Foydalanuvchi')
                    ->options(User::where('telegram_id', '!=', null)->get()->pluck('name', 'id')),

                Select::make('exam_id')
                    ->required()
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->label('Imtihonni tanlang:')
                    ->options(Exam::select(DB::raw("CONCAT(title, ' (', type, ')') as name"), 'id')->get()->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Foydalanuvchi'),
                TextColumn::make('exam.title')->label('Imtihon nomi'),
                TextColumn::make('exam.type')->label('Imtihon turi')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'speaking' => "Speaking",
                        'writing'  => "Writing",
                    };
                }),
            ])
            ->filters([
                //
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
            'index'  => Pages\ListUserExams::route('/'),
            'create' => Pages\CreateUserExam::route('/create'),
            'edit'   => Pages\EditUserExam::route('/{record}/edit'),
        ];
    }
}

<?php
namespace Filament\Resources\AttemptResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('attempt_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('attempt_id')
            ->columns([
                TextColumn::make('attempt_id'),
                TextColumn::make('question.question'),
                TextColumn::make('text')->limit(50),
                TextColumn::make('score'),
                TextColumn::make('breakdown')->limit(50),
                //TextColumn::make('feedback')->limit(50),
                TextColumn::make('message')->limit(50),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('play_audio')
                    ->iconButton()
                    ->icon('heroicon-o-speaker-wave')
                    ->modalHeading('Play Audio')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalContent(function ($record) {
                        return view('filament.modals.audio-player-modal', [
                            'audioUrl' => asset('storage/' . $record->file),
                        ]);
                    }),

                ViewAction::make()
            ])
            ->bulkActions([
            ]);
    }
}

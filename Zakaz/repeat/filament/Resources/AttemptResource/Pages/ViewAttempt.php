<?php
namespace Filament\Resources\AttemptResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\AttemptResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAttempt extends ViewRecord
{
    protected static string $resource = AttemptResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('userExam.user.name')->label('Foydalanuvchi'),
            TextEntry::make('userExam.exam.title')->label('Imtihon nomi'),
            TextEntry::make('userExam.exam.type')->label('Imtihon turi')->formatStateUsing(function ($state) {
                return $state == 'speaking' ? "Speaking" : "Writing";
            }),
        ])->columns(3);
    }
}

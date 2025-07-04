<?php

namespace Filament\Resources\SpeakingResource\Pages;

use Filament\Resources\SpeakingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpeakings extends ListRecords
{
    protected static string $resource = SpeakingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

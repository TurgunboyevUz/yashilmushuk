<?php

namespace Filament\Resources\InstrumentResource\Pages;

use Filament\Resources\InstrumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstruments extends ListRecords
{
    protected static string $resource = InstrumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

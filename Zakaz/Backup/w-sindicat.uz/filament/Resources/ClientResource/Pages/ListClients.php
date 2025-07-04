<?php

namespace Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use Filament\Resources\ClientResource;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

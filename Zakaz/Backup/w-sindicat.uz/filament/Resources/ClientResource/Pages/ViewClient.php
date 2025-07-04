<?php

namespace Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use Filament\Resources\ClientResource;
use Filament\Resources\Pages\ViewRecord;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

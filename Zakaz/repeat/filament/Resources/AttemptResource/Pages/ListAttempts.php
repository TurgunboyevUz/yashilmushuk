<?php

namespace Filament\Resources\AttemptResource\Pages;

use Filament\Resources\AttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttempts extends ListRecords
{
    protected static string $resource = AttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

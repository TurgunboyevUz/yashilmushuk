<?php

namespace Filament\Resources\PromocodeResource\Pages;

use Filament\Resources\PromocodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromocodes extends ListRecords
{
    protected static string $resource = PromocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

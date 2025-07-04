<?php

namespace Filament\Resources\RentResource\Pages;

use Filament\Resources\RentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRents extends ListRecords
{
    protected static string $resource = RentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

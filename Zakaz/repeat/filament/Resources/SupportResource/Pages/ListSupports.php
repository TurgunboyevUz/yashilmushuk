<?php

namespace Filament\Resources\SupportResource\Pages;

use Filament\Resources\SupportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupports extends ListRecords
{
    protected static string $resource = SupportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

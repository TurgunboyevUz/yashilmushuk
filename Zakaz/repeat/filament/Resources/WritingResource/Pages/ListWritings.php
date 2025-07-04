<?php

namespace Filament\Resources\WritingResource\Pages;

use Filament\Resources\WritingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWritings extends ListRecords
{
    protected static string $resource = WritingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

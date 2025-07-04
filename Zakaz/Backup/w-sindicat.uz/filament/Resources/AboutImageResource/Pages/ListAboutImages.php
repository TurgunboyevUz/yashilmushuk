<?php

namespace Filament\Resources\AboutImageResource\Pages;

use Filament\Actions;
use Filament\Resources\AboutImageResource;
use Filament\Resources\Pages\ListRecords;

class ListAboutImages extends ListRecords
{
    protected static string $resource = AboutImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

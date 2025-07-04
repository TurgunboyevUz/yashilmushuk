<?php

namespace Filament\Resources\CatalogResource\Pages;

use Filament\Actions;
use Filament\Resources\CatalogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCatalog extends ViewRecord
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

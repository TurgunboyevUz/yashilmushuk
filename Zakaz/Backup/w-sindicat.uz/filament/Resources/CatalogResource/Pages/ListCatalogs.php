<?php

namespace Filament\Resources\CatalogResource\Pages;

use Filament\Actions;
use Filament\Resources\CatalogResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListCatalogs extends ListRecords
{
    use Translatable;

    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}

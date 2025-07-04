<?php

namespace Filament\Resources\CatalogResource\Pages;

use Filament\Resources\CatalogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalog extends CreateRecord
{
    protected static string $resource = CatalogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = str($data['name']['uz-latn'])->slug();

        return $data;
    }
}

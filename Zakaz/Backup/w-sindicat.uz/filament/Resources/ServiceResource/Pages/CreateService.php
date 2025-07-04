<?php

namespace Filament\Resources\ServiceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

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

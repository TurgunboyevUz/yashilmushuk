<?php

namespace Filament\Resources\ProductResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

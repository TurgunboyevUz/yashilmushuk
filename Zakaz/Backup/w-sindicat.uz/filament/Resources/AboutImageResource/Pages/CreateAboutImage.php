<?php

namespace Filament\Resources\AboutImageResource\Pages;

use Filament\Resources\AboutImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutImage extends CreateRecord
{
    protected static string $resource = AboutImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

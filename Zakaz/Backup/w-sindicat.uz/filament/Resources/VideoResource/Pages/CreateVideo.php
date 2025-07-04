<?php

namespace Filament\Resources\VideoResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\VideoResource;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace Filament\Resources\SocialResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\SocialResource;

class CreateSocial extends CreateRecord
{
    protected static string $resource = SocialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

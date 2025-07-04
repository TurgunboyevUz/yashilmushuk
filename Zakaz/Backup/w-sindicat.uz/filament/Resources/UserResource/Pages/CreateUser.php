<?php

namespace Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

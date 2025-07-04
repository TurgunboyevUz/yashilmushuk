<?php

namespace App\Filament\Resources\HotLinkResource\Pages;

use App\Filament\Resources\HotLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHotLink extends CreateRecord
{
    protected static string $resource = HotLinkResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace Filament\Resources\YouTubeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\YouTubeResource;

class CreateYouTube extends CreateRecord
{
    protected static string $resource = YouTubeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

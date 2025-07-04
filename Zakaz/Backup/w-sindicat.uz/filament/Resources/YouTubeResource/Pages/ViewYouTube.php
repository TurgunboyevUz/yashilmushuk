<?php

namespace Filament\Resources\YouTubeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\YouTubeResource;

class ViewYouTube extends ViewRecord
{
    protected static string $resource = YouTubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

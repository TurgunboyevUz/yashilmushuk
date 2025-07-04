<?php

namespace Filament\Resources\YouTubeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\YouTubeResource;

class ListYouTubes extends ListRecords
{
    protected static string $resource = YouTubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace Filament\Resources\YouTubeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\YouTubeResource;

class EditYouTube extends EditRecord
{
    protected static string $resource = YouTubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()->hidden(function () {
                $keys = ['main-1', 'main-2', 'about'];

                return in_array($this->record->key, $keys);
            }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\TelegramResource\Pages;

use App\Filament\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTelegram extends ViewRecord
{
    protected static string $resource = TelegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

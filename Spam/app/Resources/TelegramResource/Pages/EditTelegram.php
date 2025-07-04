<?php

namespace App\Filament\Resources\TelegramResource\Pages;

use App\Filament\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTelegram extends EditRecord
{
    protected static string $resource = TelegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

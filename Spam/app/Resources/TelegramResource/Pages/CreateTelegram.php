<?php

namespace App\Filament\Resources\TelegramResource\Pages;

use App\Filament\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTelegram extends CreateRecord
{
    protected static string $resource = TelegramResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $rand_str = str()->random(10);
        $data['session_path'] = storage_path('sessions/' . $rand_str . '.madeline');

        return $data;
    }
}

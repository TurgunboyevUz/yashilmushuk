<?php

namespace App\Filament\Resources\HotLinkResource\Pages;

use App\Filament\Resources\HotLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotLink extends EditRecord
{
    protected static string $resource = HotLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

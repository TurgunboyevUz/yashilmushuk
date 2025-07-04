<?php

namespace Filament\Resources\AboutImageResource\Pages;

use Filament\Actions;
use Filament\Resources\AboutImageResource;
use Filament\Resources\Pages\EditRecord;

class EditAboutImage extends EditRecord
{
    protected static string $resource = AboutImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

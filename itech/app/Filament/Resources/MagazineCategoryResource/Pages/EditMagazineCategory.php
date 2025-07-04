<?php

namespace App\Filament\Resources\MagazineCategoryResource\Pages;

use App\Filament\Resources\MagazineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMagazineCategory extends EditRecord
{
    protected static string $resource = MagazineCategoryResource::class;

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

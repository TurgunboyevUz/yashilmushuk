<?php

namespace App\Filament\Resources\MagazineCategoryResource\Pages;

use App\Filament\Resources\MagazineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMagazineCategory extends CreateRecord
{
    protected static string $resource = MagazineCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

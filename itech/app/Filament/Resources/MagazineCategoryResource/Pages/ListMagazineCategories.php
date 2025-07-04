<?php

namespace App\Filament\Resources\MagazineCategoryResource\Pages;

use App\Filament\Resources\MagazineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMagazineCategories extends ListRecords
{
    protected static string $resource = MagazineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

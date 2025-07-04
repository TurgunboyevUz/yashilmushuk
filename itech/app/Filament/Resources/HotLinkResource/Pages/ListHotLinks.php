<?php

namespace App\Filament\Resources\HotLinkResource\Pages;

use App\Filament\Resources\HotLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotLinks extends ListRecords
{
    protected static string $resource = HotLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

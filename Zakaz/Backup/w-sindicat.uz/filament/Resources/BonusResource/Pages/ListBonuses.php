<?php

namespace Filament\Resources\BonusResource\Pages;

use Filament\Actions;
use Filament\Resources\BonusResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListBonuses extends ListRecords
{
    use Translatable;

    protected static string $resource = BonusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}

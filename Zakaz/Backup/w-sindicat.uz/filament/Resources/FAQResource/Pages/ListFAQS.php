<?php

namespace Filament\Resources\FAQResource\Pages;

use Filament\Actions;
use Filament\Resources\FAQResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListFAQS extends ListRecords
{
    use Translatable;

    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}

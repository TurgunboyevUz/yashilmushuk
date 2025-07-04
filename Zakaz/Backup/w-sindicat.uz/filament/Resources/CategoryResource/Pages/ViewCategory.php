<?php

namespace Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\CategoryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

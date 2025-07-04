<?php

namespace Filament\Resources\BonusResource\Pages;

use Filament\Actions;
use Filament\Resources\BonusResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBonus extends ViewRecord
{
    protected static string $resource = BonusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace Filament\Resources\FAQResource\Pages;

use Filament\Actions;
use Filament\Resources\FAQResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFAQ extends ViewRecord
{
    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\MessageHistoryResource\Pages;

use App\Filament\Resources\MessageHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMessageHistory extends ViewRecord
{
    protected static string $resource = MessageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

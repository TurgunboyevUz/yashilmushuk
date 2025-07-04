<?php

namespace App\Filament\Resources\MessageHistoryResource\Pages;

use App\Filament\Resources\MessageHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMessageHistory extends EditRecord
{
    protected static string $resource = MessageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

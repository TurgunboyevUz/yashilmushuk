<?php

namespace App\Filament\Resources\MessageHistoryResource\Pages;

use App\Filament\Resources\MessageHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMessageHistories extends ListRecords
{
    protected static string $resource = MessageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace Filament\Resources\AttemptResource\Pages;

use Filament\Resources\AttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttempt extends EditRecord
{
    protected static string $resource = AttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

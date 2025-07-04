<?php

namespace Filament\Resources\UserExamResource\Pages;

use Filament\Resources\UserExamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserExam extends EditRecord
{
    protected static string $resource = UserExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

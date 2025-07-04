<?php

namespace Filament\Resources\WritingResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\WritingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWriting extends EditRecord
{
    use FilamentRedirect;

    protected static string $resource = WritingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

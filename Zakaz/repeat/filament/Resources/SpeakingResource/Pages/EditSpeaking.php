<?php

namespace Filament\Resources\SpeakingResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\SpeakingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpeaking extends EditRecord
{
    use FilamentRedirect;

    protected static string $resource = SpeakingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

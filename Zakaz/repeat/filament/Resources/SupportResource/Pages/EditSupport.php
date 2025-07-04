<?php

namespace Filament\Resources\SupportResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\SupportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupport extends EditRecord
{
    use FilamentRedirect;

    protected static string $resource = SupportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

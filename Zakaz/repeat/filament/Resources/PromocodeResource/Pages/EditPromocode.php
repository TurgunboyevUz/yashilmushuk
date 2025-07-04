<?php

namespace Filament\Resources\PromocodeResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\PromocodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromocode extends EditRecord
{
    use FilamentRedirect;

    protected static string $resource = PromocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

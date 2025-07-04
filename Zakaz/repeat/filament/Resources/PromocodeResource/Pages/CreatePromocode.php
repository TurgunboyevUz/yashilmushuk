<?php

namespace Filament\Resources\PromocodeResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\PromocodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePromocode extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = PromocodeResource::class;
}

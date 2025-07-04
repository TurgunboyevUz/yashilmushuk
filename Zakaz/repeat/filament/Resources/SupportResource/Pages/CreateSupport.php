<?php

namespace Filament\Resources\SupportResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\SupportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSupport extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = SupportResource::class;
}

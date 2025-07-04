<?php

namespace Filament\Resources\PackageResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = PackageResource::class;
}

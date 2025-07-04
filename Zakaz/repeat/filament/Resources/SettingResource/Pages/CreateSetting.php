<?php

namespace Filament\Resources\SettingResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = SettingResource::class;
}

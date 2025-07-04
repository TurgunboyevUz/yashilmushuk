<?php

namespace Filament\Resources\CategoryResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = CategoryResource::class;
}

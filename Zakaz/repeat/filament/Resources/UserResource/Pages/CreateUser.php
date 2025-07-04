<?php
namespace Filament\Resources\UserResource\Pages;

use App\Traits\FilamentRedirect;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['email'])) {
            unset($data['email']);
        }

        if(empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }
}

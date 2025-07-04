<?php

namespace Filament\Resources\BlogResource\Pages;

use Filament\Resources\BlogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = now()->format('Y-m-d').'-'.str($data['title']['uz-latn'])->slug();

        return $data;
    }
}

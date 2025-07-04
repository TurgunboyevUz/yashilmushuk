<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['content'] = preg_replace(
            '/<figcaption(?!(?:[^>]*\bclass=["\'][^"\']*\battachment__caption--edited\b)).*?>.*?<\/figcaption>/si',
            '',
            $data['content']
        );
        

        $data['slug'] = now()->format('d-m-Y-H-i') . '-' . str($data['title'])->slug();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

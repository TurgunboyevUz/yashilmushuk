<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['content'] = preg_replace(
            '/<figcaption(?!(?:[^>]*\bclass=["\'][^"\']*\battachment__caption--edited\b)).*?>.*?<\/figcaption>/si',
            '',
            $data['content']
        );

        return $data;
    }
}

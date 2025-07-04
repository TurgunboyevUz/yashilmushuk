<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product\Category;
use App\Models\Product\Color;
use CURLFile;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $category = Category::find($data['category_id']);

        $colors = "";
        foreach($data['colors'] as $color){
            $color = Color::find($color);
            $colors .= $color->name . ', ';
        }
        $colors = substr($colors, 0, -2);

        if ($data['telegram'] === true) {
            if (count($data['image_path']) > 1) {
                $images = [];
                $params = [];
            
                foreach ($data['image_path'] as $index => $image) {
                    $attachName = "file{$index}";
                    $filePath = storage_path('app/public/' . $image);
            
                    $img = [
                        'type' => 'photo',
                        'media' => "attach://{$attachName}"
                    ];
            
                    if ($index === 0) {
                        $img = array_merge($img, [
                            'caption' => "Kategoriya: {$category->name}\nMahsulot: {$data['name']}\nRanglar: $colors"
                        ]);
                    }
            
                    $images[] = $img;
                    $params[$attachName] = new CURLFile($filePath);
                }
            
                $params['chat_id'] = env('APP_CHANNEL_ID');
                $params['media'] = json_encode($images);
                $params['parse_mode'] = 'html';
            
                bot('sendMediaGroup', $params);
            } else {
                bot('sendPhoto', [
                    'chat_id' => env('APP_CHANNEL_ID'),
                    'photo' => new CURLFile(storage_path('app/public/' . $data['image_path'][0])),
                    'caption' => "Kategoriya: {$category->name}\nMahsulot: {$data['name']}\nRanglar: $colors"
                ]);
            }            
        }

        unset($data['telegram']);

        return $data;
    }
}

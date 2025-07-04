<?php
namespace Filament\Resources\WritingResource\Pages;

use App\Models\Exam;
use App\Traits\FilamentRedirect;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\WritingResource;
use Illuminate\Database\Eloquent\Model;

class CreateWriting extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = WritingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        //dd($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $exam = Exam::create([
            'type' => $data['type'],
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'image'       => $data['image'],

            'is_free'     => $data['price_type'] == 1 ? true : false,
            'price_uzs'   => $data['price'] ?? null,
            'price_coin'  => $data['coins'] ?? null,
        ]);

        foreach ($data['part'] as $part) {
            $partModel = $exam->parts()->create([
                'title' => $part['title'],
                'description' => $part['description'] ?? null,
            ]);

            $partModel->questions()->create([
                'exam_id' => $exam->id,
                'question' => $part['question'],
                'images' => $part['images'],
            ]);
        }

        return $exam;
    }
}

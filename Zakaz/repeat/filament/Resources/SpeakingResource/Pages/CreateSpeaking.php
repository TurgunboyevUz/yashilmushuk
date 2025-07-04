<?php
namespace Filament\Resources\SpeakingResource\Pages;

use App\Models\Exam;
use App\Traits\FilamentRedirect;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\SpeakingResource;
use Illuminate\Database\Eloquent\Model;

class CreateSpeaking extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = SpeakingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($data['part'] as &$part) {
            if ($part['question_type'] !== 'argument') {
                foreach ($part['question'] as &$question) {
                    unset($question['argument_list']);
                }
            }
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $exam = Exam::create([
            'type'        => $data['type'],
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'image'       => $data['image'],

            'is_free'     => $data['price_type'] == 1 ? true : false,
            'price_uzs'   => $data['price'] ?? null,
            'price_coin'  => $data['coins'] ?? null,
        ]);

        foreach ($data['part'] as $part) {
            $partModel = $exam->parts()->create([
                'title'       => $part['title'],
                'description' => $part['description'] ?? null,
            ]);

            foreach ($part['question'] as $question) {
                if (isset($question['question_list'])) {
                    foreach ($question['question_list'] as $item) {
                        $partModel->questions()->create([
                            'exam_id'          => $exam->id,
                            'question'         => $item['question'],
                            'images'           => $item['images'] ?? [],
                            'preparation_time' => $item['preparation_time'],
                            'answer_time'      => $item['answer_time'],
                        ]);
                    }
                } else {
                    $partModel->questions()->create([
                        'exam_id'          => $exam->id,
                        'argument_list'    => $question['argument_list'] ?? [],
                        'images'           => $question['images'] ?? [],
                        'preparation_time' => $question['preparation_time'],
                        'answer_time'      => $question['answer_time'],
                    ]);
                }
            }
        }

        return $exam;
    }
}

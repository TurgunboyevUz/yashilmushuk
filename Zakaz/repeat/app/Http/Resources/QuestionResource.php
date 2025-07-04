<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'exam_id'          => $this->exam_id,
            'part_id'          => $this->part_id,
            'question'         => $this->question,
            'argument_list'    => $this->argument_list,
            'images'           => array_map(fn($image) => asset(Storage::url($image)), $this->images),
            'preparation_time' => $this->preparation_time,
            'answer_time'      => $this->answer_time,
        ];
    }
}

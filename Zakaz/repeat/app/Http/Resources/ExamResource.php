<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $user = $request->user();

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'image'        => asset(Storage::url($this->image)),
            'is_free'      => $this->is_free,
            'price_uzs'    => $this->price_uzs,
            'price_coin'   => $this->price_coin,
            'category'     => $this->whenLoaded('category', CategoryResource::make($this->category)),
            'is_favorite'  => $this->isFavourite($user),
            'is_purchased' => $this->isPurchased($user),

            'parts' => $this->whenLoaded('parts', ExamPartResource::collection($this->parts)),
        ];
    }
}

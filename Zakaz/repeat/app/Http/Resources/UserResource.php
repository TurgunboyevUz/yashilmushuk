<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'telegram_id' => $this->telegram_id,
            'photo_url' => $this->avatar ? asset(Storage::url($this->avatar)) : null,
            'name' => $this->name,
            'username' => $this->username,
            'balance' => $this->balance,
            'language' => $this->language,
        ];
    }
}

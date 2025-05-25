<?php

namespace App\Http\Resources;

use App\Enums\PlatformStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->type->icon(),
            'status' => $this->whenLoaded('pivot', function () {
                return [
                    'label' => PlatformStatus::tryFrom($this->pivot->platform_status)?->label(),
                    'color' => PlatformStatus::tryFrom($this->pivot->platform_status)?->color(),
                ];
            }),

        ];
    }
}

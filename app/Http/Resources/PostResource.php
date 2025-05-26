<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'status' => [
                'label' => $this->status->label(),
                'color' => $this->status->color(),
            ],
            'platforms' => PlatformResource::collection($this->whenLoaded('platforms')),
            'scheduled_time' => $this->scheduled_time->format('Y M d '),
            'created_at' => $this->created_at->format('Y M d H:i'),
            'updated_at' => $this->updated_at->format('Y M d H:i'),
            'deleted_at' => $this->deleted_at?->format('Y M d H:i'),
        ];
    }
}

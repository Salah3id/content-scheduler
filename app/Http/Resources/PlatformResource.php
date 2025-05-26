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
                    'label' => PlatformStatus::tryFrom($this->pivot?->platform_status)?->label(),
                    'color' => PlatformStatus::tryFrom($this->pivot?->platform_status)?->color(),
                ];
            }),
            'user_status' => $this->whenLoaded('users', function () {
                return [
                    'label' => $this->users->firstWhere('id', auth()->id())->pivot->is_active ? 'Active' : 'Inactive',
                    'color' => $this->users->firstWhere('id', auth()->id())->pivot->is_active ? 'green' : 'red',
                ];
            }),
            'posts_summary' => $this->when($this->total_posts, [
                'total_posts' => $this->total_posts ?? 0,
                'scheduled_count' => $this->scheduled_count ?? 0,
                'published_count' => $this->published_count ?? 0,
                'failed_on_publish_count' => $this->failed_on_publish_count ?? 0,
                'failed_on_delete_count' => $this->failed_on_delete_count ?? 0,
                'publishing_success_rate' => $this->publishing_success_rate ?? 0,
                'publishing_failure_rate' => $this->publishing_failure_rate ?? 0,

            ]),
        ];
    }
}

<?php

namespace App\DTOs\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class CreatePostData
{
    public function __construct(
        public string $title,
        public ?string $content,
        public Carbon $scheduled_time,
        public array $platform_ids,
        public ?UploadedFile $image,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->string('title'),
            content: $request->string('content'),
            scheduled_time: Carbon::parse($request->input('scheduled_time')),
            platform_ids: $request->input('platform_ids', []),
            image: $request->file('image'),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'scheduled_time' => $this->scheduled_time->toIso8601String(),
            'platform_ids' => $this->platform_ids,
            'image' => $this->image,
        ];
    }
}

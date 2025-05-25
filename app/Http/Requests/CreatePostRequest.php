<?php

namespace App\Http\Requests;

use App\Enums\PlatformType;
use App\Rules\PlatformValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255', new PlatformValidationRule($this->platform_ids)],
            'content'        => ['nullable', 'string', new PlatformValidationRule($this->platform_ids)],
            'scheduled_time' => ['required', 'date'],
            'platform_ids'   => ['required', 'array'],
            'platform_ids.*' => ['exists:platforms,id'],
            'image'          => ['nullable', 'image', 'max:2048', new PlatformValidationRule($this->platform_ids)],
        ];
    }
}

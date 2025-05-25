<?php

namespace App\Validators\PlatformPost;

use Illuminate\Http\Request;

class FacebookPostValidator
{
    public function rules(Request $request): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['nullable', 'string', 'max:280'],
        ];
    }
}
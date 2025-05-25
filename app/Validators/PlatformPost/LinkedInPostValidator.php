<?php

namespace App\Validators\PlatformPost;

use Illuminate\Http\Request;

class LinkedInPostValidator
{
    public function rules(Request $request): array
    {
        return [
            'title' => ['required', 'string', 'max:280'],
            'content' => ['nullable', 'string', 'max:280'],
        ];
    }
}
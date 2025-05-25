<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Platform;
use Illuminate\Support\Collection;

class PlatformValidationRule implements ValidationRule
{
    protected Collection $platformTypes;
    protected string $message = 'Invalid data for platform validation.';
    protected string $field = '';
    protected $value;

    public function __construct(array $platformIds)
    {
        $this->platformTypes = collect($platformIds)->map(function ($platformId) {
            $platform = Platform::find($platformId);
            return $platform ? $platform->type : null;
        })->filter()->unique();
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $this->field = $attribute;
        $this->value = $value;

        foreach ($this->platformTypes as $platformType) {
            $validator = $platformType->validator();

            $rules = $validator->rules(request());

            if (!isset($rules[$this->field])) {
                continue;
            }

            $fieldRules = [$this->field => $rules[$this->field]];

            $validatorInstance = \Validator::make(
                [$this->field => $value],
                $fieldRules
            );

            if ($validatorInstance->fails()) {
                $this->message = $validatorInstance->errors()->first($this->field);
                $fail($this->message);
                return;
            }
        }
    }

    public function message(): string
    {
        return $this->message;
    }
}

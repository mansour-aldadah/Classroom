<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenFile implements ValidationRule
{

    protected $types;

    public function __construct(...$types)
    {
        $this->types = $types;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = $value->getMimeType();
        if (in_array($type, $this->types)) {
            $fail('File type not allowed.');
        }
    }
}

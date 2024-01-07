<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Domain implements ValidationRule
{
    public function __construct(
        protected string $allowedDomain
    )
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Str::endsWith($value, "@{$this->allowedDomain}")) {
            $fail('validation.domain')->translate(['domain' => $this->allowedDomain]);
        }
    }
}

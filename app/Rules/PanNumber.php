<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class PanNumber implements ValidationRule
{
    /**
     * PAN format: AAAAA9999A (5 letters, 4 digits, 1 letter).
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $value = is_string($value) ? strtoupper(preg_replace('/\s+/', '', $value)) : '';

        if (!preg_match(config('kyc.validation.pan', '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'), $value)) {
            $fail(__('The :attribute must be a valid PAN (e.g. AAAAA9999A).', ['attribute' => $attribute]));
        }
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class AadhaarNumber implements ValidationRule
{
    /**
     * Aadhaar: 12 digits only.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $value = is_string($value) ? preg_replace('/\s+/', '', $value) : (string) $value;

        if (!preg_match(config('kyc.validation.aadhaar', '/^[0-9]{12}$/'), $value)) {
            $fail(__('The :attribute must be a valid 12-digit Aadhaar number.', ['attribute' => $attribute]));
        }
    }
}

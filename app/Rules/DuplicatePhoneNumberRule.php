<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class DuplicatePhoneNumberRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cleaned = preg_replace("/[\s-]+/", "", $value);
        $phone = User::where('phone', $cleaned)
            ->orWhere('formattedPhone', $cleaned)
            ->orWhere('formattedPhone', '+' . ltrim($cleaned, '+'))
            ->exists();
        return $phone ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("The phone number has already been taken!");
    }
}

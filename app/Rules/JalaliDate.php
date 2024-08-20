<?php

namespace App\Rules;

use Closure;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Contracts\Validation\ValidationRule;

class JalaliDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            // Validate the Jalali date using morilog/jalali
            $date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $value);

            if ($date === false) {
                $fail('The :attribute is not a valid Jalali date.');
            }
        } catch (\Exception $e) {
            $fail('The :attribute is not a valid Jalali date.');
        }
    }
}

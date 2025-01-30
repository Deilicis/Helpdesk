<?php

namespace App\Rules;


class DateTimeFormat
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

        $pattern = '/^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4} \d{2}:\d{2} [APap][Mm]$/';
        return preg_match($pattern, $value);
    }


    public function message()
    {
        return 'The :attribute does not match the date format.';
    }
}

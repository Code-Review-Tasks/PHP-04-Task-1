<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Checks if HTTP response code on given URL is >= 200 and <= 399
 */
class WorkingUrl implements Rule
{
    /**
     * Checks if HTTP response code on given URL is >= 200 and <= 399
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ch = curl_init($value);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_exec($ch);
        $httpcode = curl_errno($ch) ? 500 : curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode >= 200 && $httpcode <= 399;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'URL bad response code for :attribute.';
    }
}

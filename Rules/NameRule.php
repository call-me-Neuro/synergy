<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class NameRule implements Rule
{
    public function passes($attribute, $value)
    {
        $words = explode(' ', trim($value));
        $wordCount = count($words);
        return ($wordCount === 2 || $wordCount === 3);
    }


    public function message()
    {
        return 'Name should consist of 2 or 3 words';
    }
}

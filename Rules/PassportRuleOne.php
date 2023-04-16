<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class PassportRuleOne implements Rule
{
    public function passes($attribute, $value)
    {
        $value = (string) $value;
        $count = strlen($value);
        return $count === 4;
    }


    public function message()
    {
        return 'passport series should consist of 4 digits';
    }
}

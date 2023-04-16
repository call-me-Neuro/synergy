<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class PassportRuleTwo implements Rule
{
    public function passes($attribute, $value)
    {
        $count = strlen($value);
        return $count === 6;
    }


    public function message()
    {
        return 'passport number should consist of 6 digits';
    }
}

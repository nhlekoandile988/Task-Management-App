<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class DeadlineAfterTodayAN implements Rule
{
    public function passes($attribute, $value)
    {
        return Carbon::parse($value)->startOfDay()->greaterThanOrEqualTo(today());
    }

    public function message()
    {
        return 'The deadline must be today or a future date.';
    }
}

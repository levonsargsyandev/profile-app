<?php

namespace App\Rules;

use App\Services\HelperService;
use Illuminate\Contracts\Validation\Rule;

class MaxWords implements Rule
{
    private $maxCount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxCount)
    {
        $this->maxCount = $maxCount;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return HelperService::wordCountChecker($value, $this->maxCount);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given data was invalid.';
    }
}

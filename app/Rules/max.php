<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class max implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $max;
    public function __construct($max)
    {
        $this->max = $max;
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
        return $value <= $this->max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The quantity must not be greater than products stock: '.$this->max;
    }
}

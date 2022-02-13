<?php

namespace App\Rules\unit;

use Illuminate\Contracts\Validation\Rule;

class GroupUnit implements Rule
{
    private $required_fields = [
        'title'
    ];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if(! is_array($value)) return false;

        foreach($value as $val){
            $keys = array_keys($val);
            if(!array_intersect($this->required_fields, $keys)){
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'دیتای ارسالی صحیح نیست لطفا بعد از بررسی اطلاعات ارسالی مجدد امتحان کنید';
    }
}

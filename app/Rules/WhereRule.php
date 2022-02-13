<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class WhereRule implements Rule
{


    private $fields = [];
    private $wheres = [];

    private $currentMessage = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fields = request()->all();
        return $this;
    }


    //default and where statement
    public function where($condition, $rule, $message = null){

        $this->wheres[] = ['condition' => $condition, 'rule' => $rule, 'message' => $message];

        return $this;
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
        //
        foreach($this->wheres as $key => $where){
            $condition = $where['condition'];

            $result = ! (Validator::make(request()->all(), $condition))->fails();

            if($result){
                $rule = [$attribute => $where['rule']];

                $res =  !(Validator::make(request()->all(), $rule))->fails();
                if($res){
                    return true;
                }else{
                    $this->currentMessage = $where['message'];
                    return false;
                }
            }
            
            continue;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->currentMessage;
    }

    /**
     * run where's
     */

}

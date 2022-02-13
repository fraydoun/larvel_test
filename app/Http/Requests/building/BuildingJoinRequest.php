<?php

namespace App\Http\Requests\building;

use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BuildingJoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'regex:/^['.Building::Flag.'|'.Unit::Flag.'][1-9].*/'] // regex:/^[b|u][0-9].*/
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'کد واحد یا ساختمان الزامی میباشد',
            'code.regex' => 'کد ساختمان یا واحد نامعتبر است'
        ];
    }

    public function codeIsFor(){
        if(substr($this->get('code'), 0, '1') == Unit::Flag) return 'unit';

        return 'building';
    }

}

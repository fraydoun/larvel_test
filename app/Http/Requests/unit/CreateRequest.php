<?php

namespace App\Http\Requests\unit;

use App\Repositories\BuildingRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateRequest extends FormRequest
{

    public $building;
    public function __construct(BuildingRepository $buildingRepository)
    {
        $this->building = $buildingRepository;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $building = $this->building->findById($this->get('building_id'));
        $this->building = $building;
        if(! $building){
            Throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        // normal residents can't set charge for unit.
        if($this->has('charge') && !Auth::user()->can('isManager', $building)){
            $this->request->remove('charge');
            $this->request->remove('day_charge');
        }

        // if normal user (resident) not inside a building so not can create unit.
        if(!Auth::user()->can('isInsideBuilding', $building)){
            Throw new AccessDeniedHttpException('ابتدا باید وارد یک ساختمان شوید');
        }

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
            'title' => 'required|string|min:3|max:50',
            'building_id' => 'required|integer',
            'charge' => 'integer|required_with:day_charge',
            'day_charge' => 'numeric|min:1|max:31|required_with:charge',
            'phone_number' => 'min:11|max:11|regex:/^09[0-9].{8}/'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان الزامی میباشد',
            'title.string' => 'عنوان باید یک رشته باشد',
            'title.min' => 'حداقل طول عنوان باید ۳ کرکتر باشد',
            'title.max' => 'حداکثر طول عنوان باید ۵۰ کرکتر باشد',
            'building_id.required' => 'ایدی ساختمان الزامی است',
            'building_id.required' => 'یدی ساختمان باید یک عدد صحیح باشد',
            'charge.integer' => 'مقدار شارژ باید یک عدد صحیح باشد',
            'charge.required_with' => 'زمانی که روز سر رسید شارژ را انتخاب کردید، باید مقدار شارژ را مشخص کنید',
            'day_charge.required_with' => 'زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید',
            'day_charge.numeric' => 'روز سر رسید شارژ باید یک عدد باشد',
            'day_charge.min' => 'کمترین مقدار روز سر رسید شارژ ۱ میباشد',
            'day_charge.max' => 'روز سر رسید شارژ نباید بیشتر از31 باشد',
            'phone_number.max' => 'شماره تلفن باید 11 کرکتر باشد',
            'phone_number.min' => 'شماره تلفن باید 11 کرکتر باشد',
            'phone_number.regex' => 'شماره تلفن به درستی وارد نشده است',
        ];
    }
}

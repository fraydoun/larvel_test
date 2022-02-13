<?php

namespace App\Http\Requests\unit;

use App\Repositories\BuildingRepository;
use App\Rules\unit\GroupUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateGroupRequest extends FormRequest
{

    private $buildingRepo;
    public $building;

    public function __construct(BuildingRepository $repo)
    {
        $this->buildingRepo = $repo;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $building = $this->buildingRepo->findById($this->get('building_id'));
        $this->building = $building;
        if(! $building){
            Throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(!Auth::user()->can('isManager', $building)){
            Throw new AccessDeniedHttpException('شما برای این بخش دسترسی لازم را ندارید');

        }

        $units = $this->get('units');
        $countUnits = count($units);
        for($i=0; $i<$countUnits; $i++){
            $units[$i]['building_id'] = $building->id;
        }
        $this->request->remove('units');
        $this->request->add(['units' => $units]);
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
            'building_id' => 'required',
            'units' => ['required', 'array', new GroupUnit()]
        ];
    }


}

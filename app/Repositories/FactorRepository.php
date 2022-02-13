<?php


namespace App\Repositories;

use App\Models\Building;
use App\Models\Factor;
use App\Models\Resident;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;


class FactorRepository extends BaseRepository
{

    public function model()
    {
        return Factor::class;
    }

    /**
     * صدور کردن شارژ واحد با تایپ سیستم
     */
    public function issueUnitChargeInvoice(User $user, Unit $unit, $month){
        $carbon = Carbon::now();
        $data = [
            'title' => 'شارژ ' . $carbon->month($month)->jdate(' F ماه o'),
            'owner' => $user->id,
            'creator' => $unit->relBuilding->manager,
            'type' => Factor::TYPE_SYSTEM,
            'status' => Factor::STATUS_NOT_PAY,
            'item_type' => Factor::ITEM_TYPE_UNIT,
            'payment_deadline' => $carbon->addDays(10),
            'price' => $unit->charge,
            'item_id' => $unit->id,
            'part' => 0
        ];

        return $this->create($data);
    }


    public function createForUnit(Unit $unit, $data, $owner, $creator = null){
        $data['item_id'] = $unit->id;
        $data['item_type'] = Factor::ITEM_TYPE_UNIT;
        $data['owner'] = $owner;
        $data['type'] = Factor::TYPE_MANUAL;
        $data['creator'] = Auth::id();
        return $this->create($data);
    }

    public function findById($id){
        return $this->findByField('id', $id)->first();
    }


    /**
     * get factors user by id
     * @param array|int $ids
     */
    public function getCurrentUserFactorsForPay(array | int $ids, $item_type = null, $item_id = null){
        $query = $this->model->where('owner', Auth::id())->whereIn('status', [Factor::STATUS_NOT_PAY, Factor::STATUS_REJECT_CONFIRM_BY_MANAGER]);
        if(is_array($ids)){
            $query = $query->whereIn('id', $ids);
        }else{
            $query = $query->where('id', $ids);
        }
        if($item_type && $item_id){
            $query = $query->where('item_type', $item_type)->where('item_id', $item_id);
        }
        return $query->get();
    }

}

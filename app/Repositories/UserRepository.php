<?php

namespace App\Repositories;

use App\Models\Building;
use App\Models\Resident;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{

    public function model()
    {
        // TODO: Implement model() method.
        return User::class;
    }

    /**
     * find user by phone_number if not exists create
     * @var $phone_number string
     */
    public function findOrCreate($phone_number):User {
        return $this->model->firstOrCreate(['phone_number' => $phone_number]);
    }

    /**
     * find user by phone_number
     * @var $phone_number string
     * @return User | null
     *
     */
    public function findByPhoneNumber(string $phone_number){
        return $this->model->where('phone_number', $phone_number)->first();
    }


    /**
     * user has unit in building or no.
     */
    public function hasUnitInBuilding(User $user, Building $building):bool{
        $hasUnit = $user->relUnit()->wherePivot('building_id', $building->id)
            ->wherePivot('status', Resident::STATUS_ACTIVE)
            ->first();

        return $hasUnit instanceof Unit;
    }

    /**
     * user  joined in building or unit
     */
    public function joined($model, $user_id):bool{
        $condition = $model instanceof Building ? 'building_id': 'unit_id';

        return Resident::where($condition, $model->id)
                ->where('user_id', $user_id)
                ->where('status', Resident::STATUS_ACTIVE)
                ->first() instanceof Resident;
    }

    /**
     * upload avatar image
     */
    public function uploadAvatar(UploadedFile $file, int $user_id){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/user/avatar/user-'.$user_id. '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }

    /**
     * check that national_code is duplicate for current user or no.
     */
    public function isDuplicateNationalCode($national_code):bool{
        $user = $this->findByField('national_code', $national_code)->all();
        if(! $user) return false;

        if(count($user) > 1) return true;

        return $user[0]->id !== Auth::id();
    }
}

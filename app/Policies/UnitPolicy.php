<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isResident(User $user, Unit $unit){
        $activeResident = $unit->activeResident();
        if(! $activeResident) return false;

        return $activeResident->id == $user->id;
    }

    public function update(User $user, Unit $unit){
        $building = $unit->relBuilding;

        if($user->can('isManager', $building)){
            return true;
        }
    }
}

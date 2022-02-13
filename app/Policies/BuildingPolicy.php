<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuildingPolicy
{
    use HandlesAuthorization;

    public function isManager(User $user, Building $building){
        return $building->manager == $user->id;
    }

    public function isInsideBuilding(User $user, Building $building){
        $userBuildingsId = $user->relBuildings()->pluck('building.id')->toArray();
        return in_array($building->id, $userBuildingsId);
    }
}

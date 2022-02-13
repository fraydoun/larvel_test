<?php

namespace App\Policies;

use App\Models\Factor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactorPolicy
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

    public function manageFactor(User $user, Factor $factor){
        return $factor->creator == $user->id;
    }
}

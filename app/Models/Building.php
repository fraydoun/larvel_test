<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    const Flag = 'b';

    public $table = 'building';
    public $fillable = [
        'name', 'unit', 'floor', 'manager', 'wallet',
        'cash_desk', 'state', 'city', 'address',
        'sheba', 'card_number', 'bank_number',
        'name_owner_bank', 'last_name_owner_bank',
        'code', 'image'
    ];

    public $hidden = [
        'cash_desk', 'state', 'city', 'address',
        'sheba', 'card_number', 'bank_number',
        'pivot'
    ];
    
    public $appends = [
        'my_role'
    ];

    /**
     * return model user manager
     */
    public function relManager(){
        return $this->belongsTo(User::class, 'manager', 'id');
    }

    /**
     * return model users resident
     */
    public function relResidents(){
        return $this->belongsToMany(User::class, 'resident')->withTimestamps();
    }

    /**
     * return all unit's builgind.
     */
    public function relUnits(){
        return $this->hasMany(Unit::class, 'building_id', 'id');
    }


    /**
     * get building_id
     */
    public function getBuildingId(){
        return $this->id;
    }


    /**
     * add role attribute to list attributes..
     */
    public function getMyRoleAttribute(){
        if(Auth::user()->can('isManager', $this)){
            return 'manager';
        }
        return 'resident';
    }


    /**
     * when get list building for client added units that is resident .
     */
    public function getMyUnitAttribute(){
            $unit = Unit::join(Resident::getTableName(), 'unit.id', '=', 'resident.unit_id')
            ->where('unit.building_id', $this->id)
            ->where('resident.user_id', Auth::id())
            ->where('resident.status', Resident::STATUS_ACTIVE)
            ->select('unit.id', 'title')
            ->first();
            if($unit){
                $unit->setHidden(['rel_active_resident']);
            }
            return $unit;
    }

    public function getImageAttribute($value){
        return url($value);
    }

}

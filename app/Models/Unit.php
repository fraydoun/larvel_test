<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{

    use HasFactory, SoftDeletes;

    const Flag = 'u';
    public $table = 'unit';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title', 'living_people', 'count_parkings', 'number_parking',
        'number_warehouse', 'number_floor', 'charge', 'day_charge',
        'building_id', 'deleted_at'
    ];

    public $appends = ['debt', 'rel_active_resident'];

    public function relBuilding(){
        return $this->hasOne(Building::class, 'id', 'building_id');
    }

    /**
     * get resident relation.
     */
    public function relResidents()
    {
        return $this->belongsToMany(User::class, 'resident')->withTimestamps();
    }

    /**
     * get active resident relation
     */
    public function relActiveResident(){
        return $this->belongsToMany(User::class, 'resident')->where('status', Resident::STATUS_ACTIVE)->withTimestamps();
    }
    /**
     * get active resident relation.
     */
    public function activeResident(){
        return $this->relResidents()->where('status', Resident::STATUS_ACTIVE)
            ->first();
    }
    /**
     * get all factor for this unit.
     */
    public function relFactors(){
        return $this->hasMany(Factor::class, 'item_id', 'id')->where('item_type', Factor::ITEM_TYPE_UNIT);
    }
    /**
     * get building_id
     */
    public function getBuildingId(){
        return $this->building_id;
    }

    /**
     * add attribute debt to model units.
     */
    public function getDebtAttribute(){
        $activeResident = $this->activeResident();

        if(!$activeResident) return 0;

        $debt = $this->relFactors()
            ->where(function($query){
                $query->where('status', Factor::STATUS_NOT_PAY)
                ->orWhere('status', Factor::STATUS_WAITE_CONFIRM_BY_MANAGER);
            })
            ->where('owner', $activeResident->id)
            ->sum('price');
        return $debt;
    }


    public function getRelActiveResidentAttribute(){
        return $this->activeResident();
    }


}

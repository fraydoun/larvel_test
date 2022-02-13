<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'email',
        'password',
        'phone_number',
        'active',
        'avatar',
        'token_fcm'
    ];

    public $appends = ['fullName'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get all buildings.
     */
    public function relBuildings(){
        return $this->belongsToMany(Building::class, 'resident')->withTimestamps();
    }

    /**
     * relation with units.
     */
    public function relUnit(){
        return $this->belongsToMany(Unit::class, 'resident')->wherePivot('status', Resident::STATUS_ACTIVE)
            ->where('type', Resident::TYPE_RESIDENT)
            ->withTimestamps();
    }
    

    /**
     * relation with notification that receivered
     */
    public function relReceiveNotifs(){
        return $this->hasMany(Notification::class, 'receiver', 'id');
    }
    
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarAttribute($link){
        if($link)
            return url($link);
        
    }
}

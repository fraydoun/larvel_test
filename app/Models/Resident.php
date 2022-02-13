<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    const STATUS_PENDING_ACCEPT_BY_MANAGER = 2;

    const TYPE_MANAGER = 2; # مدیر
    const TYPE_RESIDENT = 1; # ساکن

    public $table = 'resident';

    public $fillable = [
        'user_id',
        'building_id',
        'unit_id',
        'status'
    ];


    public static function getTableName()
    {
        return (new self())->getTable();
    }

}

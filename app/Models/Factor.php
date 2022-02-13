<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * this const's for field type
     */
    const TYPE_SYSTEM = 1;
    const TYPE_MANUAL = 2;

    /**
     * this const's for field 'status'
     */
    const STATUS_NOT_PAY = 1;
    const STATUS_PAYED   = 2;
    const STATUS_WAITE_CONFIRM_BY_MANAGER = 3;// وقتی کاربری فاکتور رو نقدی پرداخت میکنه در مرحله اول استاتوس اون این مقدار رو میگیره
    const STATUS_REJECT_CONFIRM_BY_MANAGER = 4; //مدیر پرداخت نقدی رو قبول نکرد
    /**
     * this const's for field 'item_type'
     */
    const ITEM_TYPE_UNIT = 1;
    const ITEM_TYPE_CHARGE_MOBILE = 2;
    const ITEM_TYPE_BILL_PAYMENT = 3;


    protected $table = 'factor';

    protected $fillable = [
        'owner', 'creator', 'price', 'title', 'type', 'status', 'item_type', 'item_id', 'count', 'payment_deadline', 'part',
        'description'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function getParts($id = null){
        $types = [
            [
                'id' => 0,
                'title' => 'شارژ ساختمان'
            ],
            [
                'id' => 1,
                'title' => 'تعمیرات',
            ],
            [
                'id' => 2,
                'title' => 'جشن'
            ],
            [
                'id' => 3,
                'title' => 'سایر موارد'
            ]
        ];

        if($id){
            return $types[$id] ?? false;
        }

        return $types;
    }


    public function getPartAttribute(){
        return $this->getParts($this->attributes['part']);
    }

    /**
     * اگر factor_item == ۱ بود یعنی این فاکتور مربوط به ساختمان میشه و ساختمان اون برگشت داده میشه
     */
    public function getBuilding(){
        if($this->item_type == Factor::ITEM_TYPE_UNIT){
            return Unit::find($this->item_id)->relBuilding;
        }
        return false;
    }


    public function relPayment(){
        return $this->belongsToMany(Payment::class, 'payment_factor')->withTimestamps();
    }

}

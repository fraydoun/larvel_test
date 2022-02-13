<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    const PYMENT_MANUAL_TYPE_BANK = 0;
    const PYMENT_ZARINPAL_TYPE_BANK = 1;
    public $table = 'payment';

    public $fillable = [
        'type_bank', 'pay_data', 'payer', 'status'
    ];

    public $appends = [
        'status_label'
    ];

    protected $casts = [
        'pay_data' => 'array'
    ];


    public static function listGates(){
        return [
            [
                'id' => self::PYMENT_ZARINPAL_TYPE_BANK,
                'name' => 'zarinPal',
                'title' => 'ذرین پال',
                'icon' => 'https://files.zimahome.net/zarinpal.svg',
            ]
        ];
    }


    public function relFactors(){
        return $this->belongsToMany(Factor::class, 'payment_factor')->withTimestamps();
    }

    public function relPayer(){
        return $this->hasOne(User::class, 'id', 'payer');
    }

    public function totalPrice(){
       return $this->relFactors()->sum('price');
    }

    public function getDescription(){
        $factors = $this->relFactors;
        if(count($factors) == 1){
            return $factors[0]->description ?? 'بدون توضیحات';
        }

        $desc = 'پرداخت فاکتور ها با شناسه های';
        $ids = [];
        foreach($factors as $factor){
            $ids[] = $factor->id;
        }

        $desc .= '[' . implode(',', $ids) . ']'; 
        return $desc;
    }

    public function changeStatus($status){
        $factors = $this->relFactors->pluck('id')->toArray();
        $res = Factor::whereIn('id', $factors)->update([
            'status' => $status
        ]) == count($factors);

        $res &= $this->update(['status' => $status]);
        return $res;
    }


    // بعد از پرداخت اینترنتی باید کیف پول ساختمان به همان میزان شارژ شود یعنی اینکه مدیر طلبکار میشود از شرکت
    public function afterPayment(){
        $factors = $this->relFactors;
        foreach($factors as $factor){
            $building = $factor->getBuilding();
            if(! $building) continue;

            $building->wallet += $factor->price;
            $building->save();
        }
    }


    public function getStatusLabelAttribute(){
        switch($this->status){
            case Factor::STATUS_NOT_PAY: 
                return 'پرداخت نشده';
            case Factor::STATUS_PAYED: 
                return 'پرداخت شده';
            case Factor::STATUS_WAITE_CONFIRM_BY_MANAGER: 
                return 'منتظر تایید مدیر';
        }
    }

    public function getStatusPayed(){
        return $this->status == Factor::STATUS_PAYED;
    }
}

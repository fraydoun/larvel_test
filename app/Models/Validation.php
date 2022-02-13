<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Validation extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_USED   = 2;

    protected $table = 'validation_code';

    public $fillable = [
        'user_id',
        'code',
        'status'
    ];

    /**
     * generate new code and save in db.
     */
    public static function genrateCode($user_id){
        $newCode = rand(1000, 9999);
        $model = Validation::create([
            'user_id' => $user_id,
            'code' => $newCode,
            'status' => self::STATUS_ACTIVE,
        ]);

        return $model;
    }

    /**
     * do user has valid token that inserted 2 min ago.
     */
    public static function hasValidCode($minute = 2){

        $lastCode = Validation::where('created_at', '>', Carbon::now()->subMinutes(2))
            ->where('status', self::STATUS_ACTIVE)
            ->first();

        if($lastCode){
            return $lastCode->created_at->timestamp - (time() - ($minute * 60));
        }
        return false;
    }

    /**
     * check code is valid for user_id or no
     * @return bool
     *
     * @var integer $user_id
     * @var integer $code
     */
    public static function validate($user_id, $code):bool{
        /** @var Validation $codeExists */
        $codeExists = self::where('user_id', $user_id)
            ->where('code', $code)
            ->where('status', self::STATUS_ACTIVE)
            ->first();

        if($codeExists){
            $codeExists->update(['status' => self::STATUS_USED]);
            return true;
        }
        return false;
    }
}

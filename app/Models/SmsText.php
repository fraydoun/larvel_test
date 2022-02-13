<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsText extends Model
{
    use HasFactory;
    public $table = 'sms_texts';

    public $fillable = ['key', 'text'];

    public static function insertOrUpdate($key, $text){
        $textInserted = self::where('key', $key)->first();
        if($textInserted instanceof SmsText){
            return $textInserted->update(['text' => $text]);
        }else{
            return self::create(['key' => $key, 'text' => $text]);
        }
    }

    public static function getText($key){
        $text = self::where('key', $key)->first();
        return $text->text;
    }
}

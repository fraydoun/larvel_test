<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    const SENDER_SYSTEM = 0;

    const TYPE_NOTIFICATION = 1;
    const TYPE_PRIVATE_MESSAGE = 2;

    const NOT_READ = 0;
    const READ = 1;

    public $table = 'notification';
    public $fillable = ['receiver', 'sender', 'title', 'message', 'file', 'action', 'type', 'seen'];
    public $hidden = ['type', 'sender'];
    public $appends = ['senderInfo'];
    protected $casts = [
        'action' => 'array'
    ];

    public function getSenderInfoAttribute(){
        $system = [
            'id' => 0,
            'fullName' => 'سیستمی',
        ];

        if($this->sender == 0){
            return $system;
        }

        $sender = User::find($this->sender);
        if(! $sender){
            return $sender;
        }

        return [
            'id' => $sender->id,
            'fullName' => $sender->fullName
        ];
    }
}

<?php

namespace App\Jobs\factor;

use App\Components\sms\Sms;
use App\Models\Factor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotifCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $factors;
    private $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $factors, array $users)
    {
        $this->factors = $factors;
        $this->users   = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendSms();
    }

    private function sendSms(){
        
        $sender = new Sms();
        $phone_numbers = [];
        $count = count($this->users);

        for($i=0; $i<$count; $i++){
            $phone_numbers[] = $this->users[$i]->phone_number;
        }

        $message = ['فاکتوری با عنوان *'. $this->factors[0]->title . '* در زیماهوم برای شما ثبت شده است'];
        
        $sender->sendNormal($phone_numbers, $message);
    }
}

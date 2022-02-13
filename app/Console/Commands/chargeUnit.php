<?php

namespace App\Console\Commands;

use App\Models\Unit;
use App\Models\User;
use App\Repositories\FactorRepository;
use App\Repositories\UnitRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class chargeUnit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unit:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set charge for each month for units.';

    private $factorRepo;
    private $unitRepo;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FactorRepository $factor, UnitRepository $unit)
    {
        $this->factorRepo = $factor;
        $this->unitRepo = $unit;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $carbon = Carbon::now();
        $monthNumber = $carbon->month;
        $dayNumber   = $carbon->day;
        $units = $this->unitRepo->reachUnitChargeTime($dayNumber);
        foreach($units as $unit){
            if(!$unit->charge) continue; // if not set charge for unit . not genrate factor.

            $user = $unit->activeResident();
            $this->factorRepo->issueUnitChargeInvoice($user, $unit, $monthNumber);
            /** @todo send message to user */
        }
    }

}

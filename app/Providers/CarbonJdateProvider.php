<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Components\jdate\Jdate;
class CarbonJdateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        Carbon::setLocale('fa_IR');

        Carbon::macro('jdate', function ($format, $tr_num = 'fa') {
            return Jdate::jdate($format, self::this()->timestamp, '', '', $tr_num);
        });

    }
}

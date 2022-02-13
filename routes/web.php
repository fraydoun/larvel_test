<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;
use App\Http\Livewire\Building\ListBuilding;
use App\Http\Livewire\Settings\SetSms;
use App\Http\Livewire\User\ListUsers;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use Dotenv\Store\File\Paths;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Continue_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storageLink', function(){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});

Route::get('payment/start-pay/{token}', [PaymentController::class, 'startPay'])->name('payment.redirectToGateway');
Route::get('payment/callback', [PaymentController::class, 'callback'])->name('payment.verify');
Route::get('payment/callback/service/charge/{fid}', [PaymentController::class, 'callbackServices'])->name('payment.callback.services');
Route::get('payment/callback/service/bill/{fid}', [PaymentController::class, 'callbackServiceBill'])->name('payment.callback.service.bill');
Route::get('test-fcm', [TestController::class, 'fcmForm']);
Route::post('test-fcm', [TestController::class, 'fcmsend'])->name('send-fcm-test');

Route::get('fcm', function(){
    return view('test');
});
Route::get('admin/login', [AuthController::class, 'loginForm'])->middleware(['adminGuest'])->name('admin.login-form');
Route::post('admin/login', [AuthController::class, 'login'])->middleware(['adminGuest'])->name('admin.login');


Route::prefix('admin')->middleware(['admin'])->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('building')->middleware(['admin'])->group(function(){
        Route::get('list', ListBuilding::class)->name('admin.building.list');
    });

    Route::prefix('users')->middleware(['admin'])->group(function(){
        Route::get('list', ListUsers::class)->name('admin.users.list');
    });

    Route::prefix('settings')->group(function(){
        Route::get('sms', [SettingsController::class, 'setSmsText'])->name('admin.settings.sms');

        Route::get('push_notification', [SettingsController::class, 'push_notification'])->name('admin.settings.push_notification');
    });
});

Route::get('test', function(){
    $data = file_get_contents('../database/ProvinceData.txt');
    // unset($data['browse']);
    $data = json_decode(json_decode($data, true), true);
    $states = $data['multiCity']['data']['children'];
    foreach($states as $s){
        $province = Province::create($s);
        foreach($s['children'] as $key => $child){
            if($key == 0) continue;

            $citye = City::create($child);
        }
    }

    $cities = City::all();
    foreach($cities as $city){
            $url = 'https://api.divar.ir/v8/web-search/'.$city->slug.'/real-estate';
            $data = json_decode(file_get_contents($url), true);
            try{
                $districts = $data['input_suggestion']['ui_schema']['districts']['vacancies']['ui:options']['data']['children'];
                foreach($districts as $di){
                    $di['city'] = $city->id;
                    District::create($di);
                }
            }catch(Exception $e){
                Log::error($e->getMessage(). $city->slug);
                continue;
            }
        

        // dd(json_decode(file_get_contents(), true));
    }
});
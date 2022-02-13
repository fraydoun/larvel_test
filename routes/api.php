<?php

use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\V1\Ads\AdsController;
use App\Http\Controllers\Api\V1\BuildingController;
use App\Http\Controllers\Api\V1\FactorController;
use App\Http\Controllers\Api\V1\NotifController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\Services\BillController;
use App\Http\Controllers\Api\V1\Services\ChargeController;
use App\Http\Controllers\Api\V1\Services\InternetController;
use App\Http\Controllers\Api\V1\UnitsController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\Factor;
use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('public')->group(function(){
    Route::post('states', [\App\Http\Controllers\Api\PublicController::class, 'state']);
    Route::post('cities/{state_id}', [\App\Http\Controllers\Api\PublicController::class, 'city']);
    Route::post('factor/list-parts', [FactorController::class, 'listParts']);
    Route::post('categories', [PublicController::class, 'categories']);
});


Route::post('auth', [\App\Http\Controllers\Api\Auth\AuthController::class, 'auth']);
Route::post('verify', [\App\Http\Controllers\Api\Auth\AuthController::class, 'verify']);


Route::prefix('v1')->middleware(['auth:api'])->namespace('Api\V1')->group(function(){
    Route::prefix('users')->group(function(){
        Route::post('update', [\App\Http\Controllers\Api\V1\UserController::class, 'update']);
        Route::post('profile', [UserController::class, 'profile']);
        Route::post('get-base-info', [UserController::class, 'baseInfo']);
        Route::post('update-token-fcm', [UserController::class, 'updateTokenFirebase']);
    });

    Route::prefix('building')->group(function(){
        Route::post('create', [\App\Http\Controllers\Api\V1\BuildingController::class, 'create'])
        ->middleware('throttle:5,1');

        Route::post('join', [\App\Http\Controllers\Api\V1\BuildingController::class, 'join']);
        Route::post('my-building', [\App\Http\Controllers\Api\V1\BuildingController::class, 'myBuilding']);
        Route::post('list-units/{building_id}', [BuildingController::class, 'listUnits']);
        Route::post('full-info/{building_id}', [BuildingController::class, 'fullInfo']);
        Route::post('change-manager', [BuildingController::class, 'changeManager']);
        Route::post('delete/{building_id}', [BuildingController::class, 'delete']);
        Route::post('update', [BuildingController::class, 'update']);
    });

    Route::prefix('unit')->group(function(){
        Route::post('single-create', [\App\Http\Controllers\Api\V1\UnitsController::class, 'create']);
        Route::post('group-create', [\App\Http\Controllers\Api\V1\UnitsController::class, 'createGroup']);
        Route::post('info', [\App\Http\Controllers\Api\V1\UnitsController::class, 'info']);
        Route::post('factors', [\App\Http\Controllers\Api\V1\UnitsController::class, 'factors']);
        Route::post('delete/{unit_id}', [UnitsController::class, 'delete']);
        Route::post('inactive-resident', [UnitsController::class, 'inactiveResident']);
        Route::post('update', [UnitsController::class, 'update']);
    });

    Route::prefix('factor')->group(function(){
       Route::post('create', [\App\Http\Controllers\Api\V1\FactorController::class, 'create']);
       Route::post('delete', [\App\Http\Controllers\Api\V1\FactorController::class, 'delete']);
       Route::post('buy-charge', [FactorController::class, 'buyCharge']);
    });

    Route::prefix('payment')->group(function(){
        Route::post('list-gates', [PaymentController::class, 'listGates']);
        Route::post('request', [PaymentController::class, 'requestPayment']);
        Route::post('manual-payment', [PaymentController::class, 'manualPayment']);
        Route::post('list-payment-manual', [PaymentController::class, 'listPaymentsManual']);
        Route::post('manual-payment-confirmation', [PaymentController::class, 'manualPaymentConfirmation']);
    });

    Route::prefix('notification')->group(function(){
        Route::post('create', [NotifController::class, 'create']);
        Route::post('list', [NotifController::class, 'getMyNotif']);
        Route::post('info', [NotifController::class, 'getInfoNotif']);
    });


    Route::prefix('services')->group(function(){
        Route::prefix('charge')->group(function(){
            Route::post('topup', [ChargeController::class, 'topup']);
        });
        Route::prefix('bill')->group(function(){
            Route::post('url-payment', [BillController::class, 'bill']);
        });
        Route::prefix('internet')->group(function(){
            Route::post('packages', [InternetController::class, 'packages']);
            Route::post('payment-link', [InternetController::class, 'paymentLink']);
        });
    });

    Route::prefix('ads')->group(function(){
        Route::prefix('category')->group(function(){
            Route::get('{category:id}/create', [AdsController::class, 'itemForm']); // get list category and each form category... 

        });

    });
});

<?php

namespace App\Http\Controllers;

use App\Components\paymentGateway\Gateway;
use App\Components\services\charge\ChargeService;
use App\Jobs\factor\SendNotifPayment;
use App\Models\Factor;
use App\Models\Payment;
use App\Notifications\factor\NotifPaymentSuccessfull;
use App\Notifications\services\BuyChargeTopupNotif;
use App\Repositories\PaymentRepository;
use Exception;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{
    private $payment;

    public function __construct(PaymentRepository $payment)
    {
        $this->payment = $payment;
    }
    /**
     * start payment (redirect to gateWay)
     */
    public function startPay(Request $request, $token){
        
        $data = (new Hashids())->decode($token);

        list($user_id, $payment_id) = $data;

        /** @var Payment $payment */
        $payment = $this->payment->findById($payment_id);
        if(! $payment || !$payment->pay_data){
            /** @todo return view html. */
            throw new NotFoundHttpException('درخواستی برای پرداخت یافت نشد');
        }

        $gateWay = Gateway::getInstance($payment);
        return redirect($gateWay->getRedirectUrl());
    }

    public function callback(Request $request){
        $payment = $this->payment->findById($request->get('payment_id'));
        if(! $payment){
            /** @todo return view html. */
            throw new NotFoundHttpException('درخواست پرداخت در سیستم یافت نشد . در صورت کسر وجه تا 24 ساعت اینده به حساب شما بازگشت داده خواهد شد .');
        }

        $gateWay = Gateway::getInstance($payment);

        

        if($gateWay->verify()){
            DB::beginTransaction();
            $result = $payment->changeStatus(Factor::STATUS_PAYED);
            if($result){
                // SendNotifPayment::dispatch($payment);
                Notification::send(null, new NotifPaymentSuccessfull($payment));
                $payment->afterPayment();
                DB::commit();
                $status = true;
                return view('payment.callback', compact('result', 'payment'));
                dd('پرداخت با موفقیت انجام شد و قرار هست صفحه نمایش داده شود');
            }else{
                DB::rollBack();
            }
        }  
        $result = false;      
        return view('payment.callback', compact('result', 'payment'));
        dd('تراکنش غیر مجاز است . صفحه باید نمایش داده شود');
        
    }


    public function callbackServices(Request $request, $fid){
        $factor = Factor::find($fid);
        if(! $factor){
            // show 404 page.
            dd('404');
        }

        $payment = $factor->relPayment()->first();
        
        $service = ChargeService::getInstance();
        if($service->checkTransaction($payment)){
            $result = $payment->changeStatus(Factor::STATUS_PAYED);
            $notifClass = $service->getNotificationClass();
            if($notifClass && class_exists($notifClass)){
                $payment->relPayer->notify(new $notifClass($factor->toArray()));
            }
        }else{
            $status = false;
            $result = false;
        }
        return view('payment.callback', compact('result', 'payment'));
    }



}

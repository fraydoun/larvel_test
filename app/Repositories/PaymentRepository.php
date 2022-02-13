<?php


namespace App\Repositories;

use App\Models\Building;
use App\Models\Factor;
use App\Models\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;


class PaymentRepository extends BaseRepository
{

    public function model()
    {
        return Payment::class;
    }

    public function findById($id){
        return $this->findByField('id', $id)->first();
    }


    /**
     * upload  document
     */
    public function uploadDocument(UploadedFile $file, Payment $payment){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/payment/document-'.$payment->id. '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }

    /**
     * get list payments that type is manual for one building.
     */
    public function getListManualPaymentsBuilding(Building $building){
        $unit_id = $building->relUnits()->select('id')->get()->pluck('id')->toArray();
        $factor_ids = Factor::whereIn('item_id', $unit_id)
            ->where('item_type', Factor::ITEM_TYPE_UNIT)
            ->where('status', Factor::STATUS_WAITE_CONFIRM_BY_MANAGER)
            ->select('id')
            ->get()->pluck('id')->toArray();

        $payments = Payment::join('payment_factor', 'payment_factor.payment_id', '=', 'payment.id')
            ->whereIn('factor_id', $factor_ids)
            ->where('status', Factor::STATUS_WAITE_CONFIRM_BY_MANAGER)
            ->select('payment.*')
            ->distinct()
            ->with('relPayer:id,first_name,last_name', 'relFactors')
            ->get();
       
        return $payments;


    }
}

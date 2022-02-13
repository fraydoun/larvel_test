
<html>
    <head></head>
    <body>
        @if($payment->getStatusPayed())
            <span>پرداخت شما با موفقیت انجام شد</span>
            @php
                $device = $payment->pay_data['device'] ?? 'web';
                switch ($device) {
                    case 'web':
                        $fids = $payment->relFactors->pluck('id')->toArray();
                        $link = 'https://front.zimahome.net/#/panel/payment?type=factor&success=true&fids='.implode(',', $fids).'&payment_id='.$payment->id.'&' . http_build_query($payment->pay_data);
                        break;
                    
                    default:
                        # code...
                        $link = '';
                        break;
                }
            @endphp
            <br>
            <a href="{{$link}}">برای بازگشت به برنامه کلیک کنید</a>
        @else 
            <span>پرداخت انجام نشد</span>
            @php
                $device = $payment->pay_data['device'] ?? 'web';
                switch ($device) {
                    case 'web':
                        $fids = $payment->relFactors->pluck('id')->toArray();
                        $link = 'https://front.zimahome.net/#/panel/payment?type=factor&success=false&fids='.implode(',', $fids).'&payment_id='.$payment->id.'&' . http_build_query($payment->pay_data);
                        break;
                    
                    default:
                        # code...
                        $link = '';
                        break;
                }
            @endphp
            <br>
            <a href="{{$link}}">برای بازگشت به برنامه کلیک کنید</a>
        @endif;
    </body>
</html>
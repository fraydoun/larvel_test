<div class="col-12">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4> ارسال پوش نوتیفیکیشن برای همه ساکنان:</h4>
                    </div>                 
                </div>
            </div>
            <div class="widget-content widget-content-area">
                
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto">
                        @if (session()->has('success'))
                        <div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> <strong>{{session('success')}}</strong>  </div>
                        @endif
                        <div class="form-group">
                            <p>  عنوان پوش نوتیفیکیشن</p>
                            <label for="t-text" class="sr-only">متن</label>
                            <input wire:model.defer="title" id="t-text" type="text" name="title" placeholder="عنوان پوش نوتیفیکیشن" class="form-control" required="">
                            @error('title')
                            <code >{{$message}}</code><br>
                            @enderror
                            
                        </div>
                        
                        <div class="form-group">
                            <p>متن پوش نوتیفیکیشن</p>
                            <label for="t-text" class="sr-only">متن</label>
                            <input wire:model.defer="text" id="t-text" type="text" name="text" placeholder="متن پوش نوتیفیکیشن" class="form-control" required="">
                            @error('text')
                            <code >{{$message}}</code><br>
                            @enderror
                            <button wire:click="save" class="mt-4 btn btn-primary"> ارسال </button>
                        </div>
                    </div>                                        
                </div>
                
            </div>
        </div>
    </div>
</div>

{{-- 
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
    
    var firebaseConfig = {
        apiKey: "AIzaSyBu7PGp3cCYojqn2N0Ua101GE7bcfqTmBE",
        authDomain: "push-notification-3ba5f.firebaseapp.com",
        projectId: "push-notification-3ba5f",
        storageBucket: "push-notification-3ba5f.appspot.com",
        messagingSenderId: "957841785736",
        appId: "1:957841785736:web:b4bc23e58275bbaeb0b03d",
        measurementId: "G-5EVZS7G8NL"
    };
    
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    
    //$(window).load(function(){ initFirebaseMessagingRegistration(); });
    
    function initFirebaseMessagingRegistration() {
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            
            console.log(token);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '{{ route("update-token-fcm") }}',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    alert('Token saved successfully.');
                },
                error: function (err) {
                    //console.log( err);
                },
            });
            
        }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }
    
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
    
</script>
 --}}

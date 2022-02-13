<div class="col-12">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>متن پیامک درخواست تایید فاکتور بصورت دستی توسط کاربر برای مدیر ساختمان:</h4>
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
                                <p> برای جایگزاری عنوان فاکتور از <code>{factor_title}</code> و همچنین برای جایگزاری نام درخواست دهنده از <code>{user_name}</code> استفاده کنید</p>
                                <label for="t-text" class="sr-only">متن</label>
                                <input wire:model.defer="text" id="t-text" type="text" name="txt" placeholder="مثال: فاکتور با عنوان {factor_title} توسط کاربر {user_name} بصورت دستی پرداخت شده برای تایید به برنامه بروید" class="form-control" required="">
                                @error('text')
                                    <code >{{$message}}</code><br>
                                @enderror
                                <button wire:click="save" class="mt-4 btn btn-primary"> ثبت </button>
                            </div>
                    </div>                                        
                </div>

            </div>
        </div>
    </div>
</div>

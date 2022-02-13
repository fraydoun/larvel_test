@extends('layouts.auth')

@section('title')
    ورود به سیستم
@endsection


@section('content')
<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">ورودی</h1>
                    <p class="">برای ادامه به حساب کاربری خود وارد شوید</p>
                    @if($message = session()->get('error'))
                        <div class="alert alert-danger alert-block">
                            <strong>{{$message}}</strong>
                        </div>
                    @endif
                    <form class="text-left" action="{{route('admin.login')}}" method="POST">
                        @csrf
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="username">نام کاربری</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="username" name="username" type="text" class="form-control" value="{{old('username')}}" placeholder="نام کاربری خود را وارد کنید">
                                @error('username')
                                    <span class="error_message">{{$message}}</span>
                                @enderror
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">رمزعبور</label>
                                    <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">رمز عبور را فراموش کرده اید؟</a>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="password" type="password" class="form-control" placeholder="رمز عبور خود را وارد کنید">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                @error('password')
                                    <span class="error_message">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" value="">ورود به سیستم</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>                    
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        .error_message{
            color:rgb(233, 79, 79);
        }
    </style>
@endsection
@extends('layouts.dashboard')


@section('content')
    {{-- @livewire('dashboard.settings.sms.notification.push-notification') --}}
    @livewire('dashboard.settings.sms.factors.factor-created')
    @livewire('dashboard.settings.sms.factors.manual-payment-request')
    @livewire('dashboard.settings.sms.factors.payment-manual-confirm')
    @livewire('dashboard.settings.sms.factors.payment-manual-reject')

@endsection
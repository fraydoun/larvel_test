@extends('layouts.dashboard')

@section('content')
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        @livewire('dashboard.user-counts')    
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        @livewire('dashboard.buildings-counts')    
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        @livewire('dashboard.unit-count')    
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        @livewire('dashboard.resident-details')
    </div>
@endsection


@section('css')
<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('script')
@yield('test')
@endsection
<div>
    <div class="widget widget-chart-three">
        <div class="widget-heading">
            <div class="">
                <h5 class="">ساکنیین در طول امسال</h5>
            </div>

            <div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </a>

            </div>
        </div>

        <div class="widget-content" style="position: relative;">
            <div id="uniqueVisits" style="min-height: 365px;"></div>
            <div class="resize-triggers">
                <div class="expand-trigger">
                    <div style="width: 935px; height: 366px;"></div>
                </div>
                <div class="contract-trigger"></div>
            </div>
        </div>
    </div>
    
    @section('script')
    <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/dashboard/dash_2.js')}}"></script>
    @endsection
</div>

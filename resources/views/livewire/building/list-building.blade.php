<div class="col-12">
    <div id="tableCaption" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4> لیست کل ساختمان ها </h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table mb-4">
                      <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>نام</th>
                                <th>تعداد واحدها</th>
                                <th class="">تعداد طبقات</th>
                                <th> مدیر </th>
                                <th>بستانکار</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($buildings as $building)
                                <tr>
                                    <td class="text-center">{{((($buildings->currentPage() -1 )* $buildings->perPage()) + $loop->index+1)}}</td>
                                    <td class="text-success">{{$building->name}}</td>
                                    <td>{{$building->unit}}</td>
                                    <td>{{$building->floor}}</td>
                                    <td>{{$building->relManager->full_name}}
                                    <td class=""><span class=" shadow-none badge outline-badge-primary"> {{$building->wallet}} تومان </span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $buildings->links('admin.pagination') }}
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div id="tableCaption" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4> لیست همه کاربران </h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table mb-4">
                      <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>نام و نام خانوادگی</th>
                                <th>شماره تلفن</th>
                                <th class="">ساختمان فعال</th>
                                <th> واحد فعال </th>
                                <th>میزان بدهی به ساختمان</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                @php
                                    $building = $user->relBuildings()->wherePivot('status', 1)->first();
                                    $unit = $user->relUnit()->wherePivot('status', 1)->first();

                                    $building_name = $building? $building->name: '<span class=" shadow-none badge outline-badge-danger"> وارد ساختمانی نشده</span>';
                                    $unit_title = $unit? $unit->title: '<span class=" shadow-none badge outline-badge-danger"> وارد واحدی نشده</span>';
                                @endphp
                                <tr>
                                    <td class="text-center">{{((($users->currentPage() -1 )* $users->perPage()) + $loop->index+1)}}</td>
                                    <td class="text-success">{{$user->full_name}}</td>
                                    <td>{{$user->phone_number}}</td>
                                    <td>{!!$building_name!!}</td>
                                    <td>{!!$unit_title!!}</td>
                                    <td class="">@if(isset($bulding) && $building) <span class=" shadow-none badge outline-badge-primary"> {{$building->wallet}} تومان </span>@else 0 تومان @endif</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links('admin.pagination') }}
            </div>
        </div>
    </div>
</div>

@extends('layouts.admin')
@section('content')
<style>
    .scrollable-branches {
        max-height: 300px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }
</style>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Support Form <span class='fw-300'>Dashboard</span>
        </h1>
        <div class="mr-1">
            <label class="fs-sm mb-0 mt-2 mt-md-0">From</label>
            <input type="date" class="form-control" id="from_date" placeholder="from date">
        </div>
        <div>
            <label class="fs-sm mb-0 mt-2 mt-md-0">To</label>
            <input type="date" class="form-control" id="to_date" placeholder="To date">
        </div>
    </div>
    <div class="row">
        @can('Dashboad New Ticket')
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="total-new-ticket" class="float-end">0</span>
                            <small class="m-0 l-h-n">New Ticket</small>
                        </h3>
                    </div>
                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
        @endcan
        @can('Dashboad Ticket Critical')
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="total-priority" class="float-end">0</span>
                            <small class="m-0 l-h-n">Ticket Urgent</small>
                        </h3>
                    </div>
                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
        @endcan
        @can('Dashboad Ticket Assign')
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="total-assign" class="float-end">0</span>
                            <small class="m-0 l-h-n">Ticket Assign</small>
                        </h3>
                    </div>
                    <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                </div>
            </div>
        @endcan
        @can('Dashboad Ticke Active')
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="total-ticke-active" class="float-end">0</span>
                            <small class="m-0 l-h-n">Ticke Active</small>
                        </h3>
                    </div>
                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div id="panel-9" class="panel">
                <div class="panel-hdr">	
                    <h2>
                        Ticke Priority <span class="fw-300"><i>Chart</i></span> 
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">									
                        <div class="panel-tag">
                            Display as Ticke Priority Chart
                        </div>
                        <div id="priorityChart" style="width:100%; height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div id="panel-10" class="panel">
                <div class="panel-hdr">	
                    <h2>
                        Titcket Status <span class="fw-300"><i>Chart</i></span> 
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">									
                        <div class="panel-tag">
                            Display as Ticket status Chart
                        </div>
                        <div id="ticketStatus" style="width:100%; height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row"> 
        @can('Dashboad Maintenance Mission By Branch')
            <div class="col-xl-6">
                <div id="panel-9" class="panel">
                    <div class="panel-hdr">    
                        <h2>Maintenance Mission By Branch</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    
                    <div class="panel-container show">
                        <div class="panel-content border-faded border-left-0 border-right-0 border-top-0">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- Scrollable container start -->
                                    <div style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($results as $item)
                                            @php
                                                $completed = 0 ;
                                                foreach ($item['missions'] as $value) {
                                                    $completed += $value['status']; 
                                                }
                                            @endphp
                                            <div class="d-flex mt-2">
                                                Branch {{ $item['abbreviations'] }}
                                                <span class="ml-auto">
                                                    <strong>({{ $completed }} / 4)</strong>
                                                </span>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <!-- Scrollable container end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('Dashboad Asset By Branch')
            <div class="col-xl-6">
                <div id="panel-9" class="panel">
                    <div class="panel-hdr">    
                        <h2>Asset By Branch</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content border-faded border-left-0 border-right-0 border-top-0">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- Scrollable container start -->
                                    <div style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($branch as $item)
                                            @php
                                                $recordsTotal = App\Models\Asset::where('office',$item->id)->count(); 
                                            @endphp
                                            <div class="d-flex mt-2">
                                                Branch {{$item->abbreviations}}
                                                <span class="ml-auto"><strong>{{$recordsTotal}}</strong></span>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <!-- Scrollable container end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>  
    <div class="row"> 
        @can('Dashboad Maintenance Mission By Department')
            <div class="col-xl-6">
                <div id="panel-9" class="panel">
                    <div class="panel-hdr">    
                        <h2>Maintenance Mission By Department</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    
                    <div class="panel-container show">
                        <div class="panel-content border-faded border-left-0 border-right-0 border-top-0">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- Scrollable container start -->
                                    <div style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($resultsDepartment as $item)
                                            @php
                                                $completed = 0 ;
                                                foreach ($item['missions'] as $value) {
                                                    $completed += $value['status']; 
                                                }
                                            @endphp

                                            <div class="d-flex mt-2">
                                                {{ $item['name_english'] }}
                                                <span class="ml-auto">
                                                    <strong>({{ $completed }} / 4)</strong>
                                                </span>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>                                
                                    <!-- Scrollable container end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('Dashboad Asset By Department')
            <div class="col-xl-6">
                <div id="panel-9" class="panel">
                    <div class="panel-hdr">    
                        <h2>Asset By Department</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                
                    <div class="panel-container show">
                        <div class="panel-content border-faded border-left-0 border-right-0 border-top-0">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- Scrollable container start -->
                                    <div style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($departments as $item)
                                            @php
                                                $recordsTotal = App\Models\Asset::where('department_id',$item->id)->count(); 
                                            @endphp
                                            <div class="d-flex mt-2">
                                                {{$item->name_english}}
                                                <span class="ml-auto"><strong>{{$recordsTotal}}</strong></span>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <!-- Scrollable container end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        @can('Dashboad Maintenance Mission Scheduled Chart')
            <div class="col-xl-6">
                <div id="panel-11" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Maintenance Mission Scheduled <span class="fw-300"><i>Chart</i></span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div id="maintenaceMissionChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @can('Dashboad Maintenance Mission Cash By Cash Chart')
            <div class="col-xl-6">
                <div id="panel-11" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Maintenance Mission Cash By Cash <span class="fw-300"><i>Chart</i></span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div id="maintenaceCashByCashChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        @can('Dashboad User Online')
            <div class="col-lg-12 sortable-grid ui-sortable">
                <div id="panel-4" class="panel panel-sortable" role="widget">
                    <div class="panel-hdr" role="heading">
                        <h2 class="ui-sortable-handle">
                            Users <span class="fw-300"><i>Online</i></span>
                        </h2>
                        
                        <div class="panel-saving mr-2" style="display:none"><i class="fal fa-spinner-third fa-spin-4x fs-xl"></i></div>
                        <div class="panel-toolbar" role="menu">
                            <a href="#" class="btn btn-panel hover-effect-dot js-panel-collapse waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></a> 
                            <a href="#" class="btn btn-panel hover-effect-dot js-panel-fullscreen waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></a> 
                            <a href="#" class="btn btn-panel hover-effect-dot js-panel-close waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></a>
                        </div>
                        <div class="panel-toolbar" role="menu">
                            <a href="#" class="btn btn-toolbar-master waves-effect waves-themed" data-toggle="dropdown"><i class="fal fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-right p-0">
                                <a href="#" class="dropdown-item js-panel-refresh"><span data-i18n="drpdwn.refreshpanel">Refresh Content</span></a> 
                                <a href="#" class="dropdown-item js-panel-locked"><span data-i18n="drpdwn.lockpanel">Lock Position</span></a>
                                <div class="dropdown-multilevel dropdown-multilevel-left">
                                    <div class="dropdown-item"> <span data-i18n="drpdwn.panelcolor">Panel Style</span> </div>
                                    <div class="dropdown-menu d-flex flex-wrap" style="min-width: 9.5rem; width: 9.5rem; padding: 0.5rem">
                                        <a href="#" class="btn d-inline-block bg-primary-700 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-primary-700 bg-success-gradient" style="margin:1px;"></a>
                                        <a href="#" class="btn d-inline-block bg-primary-500 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-primary-500 bg-info-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-primary-600 bg-primary-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-primary-600 bg-primary-gradient" style="margin:1px;"></a>
                                        <a href="#" class="btn d-inline-block bg-info-600 bg-primray-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-info-600 bg-primray-gradient" style="margin:1px;"></a>
                                        <a href="#" class="btn d-inline-block bg-info-600 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-info-600 bg-info-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-info-700 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-info-700 bg-success-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-success-900 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-success-900 bg-info-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-success-700 bg-primary-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-success-700 bg-primary-gradient" style="margin:1px;"></a>
                                        <a href="#" class="btn d-inline-block bg-success-600 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-success-600 bg-success-gradient" style="margin:1px;"></a>
                                        <a href="#" class="btn d-inline-block bg-danger-900 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-danger-900 bg-info-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-fusion-400 bg-fusion-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-fusion-400 bg-fusion-gradient" style="margin:1px;"></a> 
                                        <a href="#" class="btn d-inline-block bg-faded width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed" data-panel-setstyle="bg-faded" style="margin:1px;"></a>
                                    </div>
                                </div>
                                <div class="dropdown-divider m-0">
                                </div>
                                <a href="#" class="dropdown-item js-panel-reset"><span data-i18n="drpdwn.resetpanel">Reset Panel</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-container show" role="content">
                        <div class="loader"><i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i></div>
                        <div class="panel-content">
                            <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info" style="width: 1162px;">
                                            <thead class="bg-warning-200">
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>User Name</th>
                                                <th>Role</th>
                                                <th>Branch</th>
                                                <th>Login DateTime</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @if (count($data)>0)
                                                    @foreach ($data as $item)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1" tabindex="0">
                                                                <img
                                                                    src="{{ $item->profile ? asset('storage/users/profile/' . $item->profile) : asset('admins/img/demo/avatars/avatar-m.png') }}" 
                                                                    class="profile-image rounded-circle" 
                                                                    alt="{{ $item->name }}" 
                                                                    style="width: 50px; cursor: pointer;"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#profileImageModal"
                                                                    onclick="showProfileImage('{{ $item->profile ? asset('storage/users/profile/' . $item->profile) : asset('admins/img/demo/avatars/avatar-m.png') }}')">
                                                            </td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->email}}</td>
                                                            <td>{{$item->user}}</td>
                                                            <td>{{$item->role_name}}</td>
                                                            <td>{{$item->branch_name_en}}</td>
                                                            <td>{{$item->dt}}</td>
                                                            <td>
                                                                @if ($item->userOnline->isUserOnline())
                                                                    <span class="btn btn-sm btn-success"> Online</span>
                                                                @else
                                                                    <span class="btn btn-sm btn-danger"> Offline</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" data-id="{{$item->user_id}}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block btn_delete_user_onlin"><i class="ni ni-reload" style="font-size: 12px"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center" style="padding:0% !important">
                    <img id="modalProfileImage" src="" alt="Profile Picture" class="img-fluid rounded" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@include('includs.datatable_basic')
    <script>
        function showProfileImage(imageUrl) {
            $("#profileImageModal").modal("show");
            document.getElementById('modalProfileImage').src = imageUrl;
        }
        $(function() {
            $("#from_date").on('change',function(){
            });
            $('.btn_delete_user_onlin').on('click',function(){
                let user_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/user/online/delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        user_id : user_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == "success") {
                            toastr.success('Create user successfully.');
                            window.location.replace("{{ URL('admin/dashboad') }}"); 
                        }
                    }
                });
            });
            
            $.ajax({
                type: "GET",
                url: "{{ url('admin/dashboad/show') }}",
                data: "data",
                dataType: "JSON",
                success: function(response) {
                    let dataPriorities = response.priorities;
                    let user_id = 0;
                    if (response.dataTickets.length > 0) {
                        var newTicket = 0;
                        var priority = 0;
                        var assign = 0;
                        var tickeActive = 0;
                        response.dataTickets.map((item) => {
                            if (item.status == 1) {
                                newTicket++;
                            }
                            if (item.priority == 1) {
                                priority++;
                            }
                            response.users.forEach(user => {
                                if (item.owner == user.id) {
                                    assign++;
                                } 
                            });
                            
                            if(item.status) {
                                tickeActive++;
                            }
                        });
                        $('#total-new-ticket').text(Number(newTicket).toLocaleString());
                        $('#total-priority').text(Number(priority).toLocaleString());
                        $('#total-assign').text(Number(assign).toLocaleString());
                        $('#total-ticke-active').text(Number(tickeActive).toLocaleString());
                    }
                    let data = {
                        dataTickets: response.dataTickets,
                        customStatuses: response.customStatuses,
                        priorities: response.priorities,
                        maintenanceMission: response.maintenanceMission,
                        maintenanceMissionCashByCash: response.maintenanceMissionCashByCash,
                        branch: response.branch,
                        maintenanceStatus: response.maintenanceStatus,
                    }
                    TicketStatus(data);
                    TicketPriority(data);
                    getMaintenanceMission(data);
                    getMaintenanceMissionCashByCash(data);
                }
            });
        });

        // status ticket priority
        function TicketPriority(datas){
            let TotalPriority = {};
            datas.priorities.forEach(status => {
                TotalPriority[status.id] = 0;
            });

            if (datas.dataTickets.length>0) {
                datas.dataTickets.map((item)=>{
                    if (TotalPriority[item.priority] !== undefined) {
                        TotalPriority[item.priority]++;
                    }
                });
            } 
            // function each priority name
            let prioritName = datas.priorities.map((item) => {
                return [item.name, TotalPriority[item.id]];
            });
            // priority Colors
            let priorityColors = datas.priorities.map((item) => {
                return [item.color];
            });
            var priorityChart = c3.generate({
                bindto: "#priorityChart",
                data: {
                    // iris data from R
                    columns: prioritName,
                    type : 'pie'//,
                },
                color: {
                    pattern: priorityColors
                }
            });
        }
        // ticket status
        function TicketStatus(datas){
            let statusCounters = {};
            datas.customStatuses.forEach(status => {
                statusCounters[status.id] = 0;
            });
            if (datas.dataTickets.length>0) {
                datas.dataTickets.map((item)=>{
                    if (statusCounters[item.status] !== undefined) {
                        statusCounters[item.status]++;
                    }
                });
            } 
            // function each custom status
            let statusName = datas.customStatuses.map((status) => {
                return [status.name, statusCounters[status.id]];
            });
            // function each custom status
            let statusColor = datas.customStatuses.map((status) => {
                return [status.color];
            });
            var ticketStatus = c3.generate({
                bindto: "#ticketStatus",
                data: {
                    columns: statusName,
                    type : 'donut',
                },
                donut: {
                    title: "Ticket Status"
                },
                color: {
                    pattern: statusColor
                }
            });
        }

        function getMaintenanceMission(datas) {
            let dataMaintenance = {};
            datas.maintenanceMission.forEach(itemMaintenance => {                
                const branchIndex = Array.isArray(datas.branch) ? datas.branch.findIndex(itemPranch => itemPranch.id == itemMaintenance.office) : -1;                
                if (branchIndex !== -1) {
                    itemMaintenance.maintenance_detail.forEach(detail => {
                        const matchedStatus = datas.maintenanceStatus.find(s => s.id == detail.status);
                        if (matchedStatus) {
                            const value = Number(detail.total) || 1;
                            if (!dataMaintenance[matchedStatus.name]) {
                                dataMaintenance[matchedStatus.name] = Array(datas.branch.length).fill(0);
                            }
                            dataMaintenance[matchedStatus.name][branchIndex] += value;
                        }
                    });
                }
            });
            
            let columns = datas.maintenanceStatus.map(status => {
                return [status.name, ...(dataMaintenance[status.name] || Array(datas.branch.length).fill(0))];
            });
            
            let branchLabels = datas.branch.map(branch => branch.abbreviations);
            let maintenanceColors = datas.maintenanceStatus.map(status => status.color);
            
            // Draw chart
            var maintenaceMissionChart = c3.generate({
                bindto: "#maintenaceMissionChart",
                data: {
                    columns: columns,
                    type: 'bar',
                    groups: [datas.maintenanceStatus.map(status => status.name)]
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: branchLabels
                    }
                },
                tooltip: {
                    format: {
                        title: function (index) {
                            const branch = datas.branch[index];
                            if (!branch) return '';
                            // ✅ Count how many maintenance records belong to this branch
                            const branchTotal = datas.maintenanceMission.filter(item => item.office === branch.id).length;
                            // ✅ Count total number of maintenance records overall
                            const overallTotal = datas.maintenanceMission.length;
                            return `${branch.abbreviations} Total: ${branchTotal}`;
                        }
                    }
                },
                color: {
                    pattern: maintenanceColors
                },
                legend: {
                    show: true
                }
            });
        }
        function getMaintenanceMissionCashByCash(datas) {
            let dataMaintenance = {};
            datas.maintenanceMissionCashByCash.forEach(itemMaintenance => {                
                const branchIndex = Array.isArray(datas.branch) ? datas.branch.findIndex(itemPranch => itemPranch.id == itemMaintenance.office) : -1;                
                if (branchIndex !== -1) {
                    itemMaintenance.maintenance_detail.forEach(detail => {
                        const matchedStatus = datas.maintenanceStatus.find(s => s.id == detail.status);
                        if (matchedStatus) {
                            const value = Number(detail.total) || 1;
                            if (!dataMaintenance[matchedStatus.name]) {
                                dataMaintenance[matchedStatus.name] = Array(datas.branch.length).fill(0);
                            }
                            dataMaintenance[matchedStatus.name][branchIndex] += value;
                        }
                    });
                }
            });
            
            let columns = datas.maintenanceStatus.map(status => {
                return [status.name, ...(dataMaintenance[status.name] || Array(datas.branch.length).fill(0))];
            });
            
            let branchLabels = datas.branch.map(branch => branch.abbreviations);
            let maintenanceColors = datas.maintenanceStatus.map(status => status.color);
            
            // Draw chart
            var maintenaceCashByCashChart = c3.generate({
                bindto: "#maintenaceCashByCashChart",
                data: {
                    columns: columns,
                    type: 'bar',
                    groups: [datas.maintenanceStatus.map(status => status.name)]
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: branchLabels
                    }
                },
                tooltip: {
                    format: {
                        title: function (index) {
                            const branch = datas.branch[index];
                            if (!branch) return '';
                            // ✅ Count how many maintenance records belong to this branch
                            const branchTotal = datas.maintenanceMissionCashByCash.filter(item => item.office === branch.id).length;
                            // ✅ Count total number of maintenance records overall
                            const overallTotal = datas.maintenanceMissionCashByCash.length;
                            return `${branch.abbreviations} Total: ${branchTotal}`;
                        }
                    }
                },
                color: {
                    pattern: maintenanceColors
                },
                legend: {
                    show: true
                }
            });
        }
    </script>
@endsection

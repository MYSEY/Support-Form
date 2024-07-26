@extends('layouts.admin')
@section('content')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Support Form <span class='fw-300'>Dashboard</span>
        </h1>
        <div class="d-flex mr-4">
            <div class="mr-2">
                <span class="peity-donut"
                    data-peity="{ &quot;fill&quot;: [&quot;#967bbd&quot;, &quot;#ccbfdf&quot;],  &quot;innerRadius&quot;: 14, &quot;radius&quot;: 20 }">7/10</span>
            </div>
            <div>
                <label class="fs-sm mb-0 mt-2 mt-md-0">New Sessions</label>
                <h4 class="font-weight-bold mb-0">70.60%</h4>
            </div>
        </div>
        <div class="d-flex mr-0">
            <div class="mr-2">
                <span class="peity-donut"
                    data-peity="{ &quot;fill&quot;: [&quot;#2196F3&quot;, &quot;#9acffa&quot;],  &quot;innerRadius&quot;: 14, &quot;radius&quot;: 20 }">3/10</span>
            </div>
            <div>
                <label class="fs-sm mb-0 mt-2 mt-md-0">Page Views</label>
                <h4 class="font-weight-bold mb-0">14,134</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="total-new-ticket" class="float-end">0</span>
                        <small class="m-0 l-h-n">New Ticket</small>
                    </h3>
                </div>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="total-priority" class="float-end">0</span>
                        <small class="m-0 l-h-n">Ticket Urgent</small>
                    </h3>
                </div>
                <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                    style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="total-assign" class="float-end">0</span>
                        <small class="m-0 l-h-n">Ticket Assign</small>
                    </h3>
                </div>
                <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                    style="font-size: 8rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="total-ticke-active" class="float-end">0</span>
                        <small class="m-0 l-h-n">Ticke Active</small>
                    </h3>
                </div>
                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                    style="font-size: 6rem;"></i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Support form profits
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content bg-subtlelight-fade">
                        <div id="js-checkbox-toggles" class="d-flex mb-3">
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-0" id="gra-0"
                                    checked="checked">
                                <label class="custom-control-label" for="gra-0">Target Profit</label>
                            </div>
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-1" id="gra-1"
                                    checked="checked">
                                <label class="custom-control-label" for="gra-1">Actual Profit</label>
                            </div>
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-2" id="gra-2"
                                    checked="checked">
                                <label class="custom-control-label" for="gra-2">User Signups</label>
                            </div>
                        </div>
                        <div id="flot-toggles" class="w-100 mt-4" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="panel-2" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
                <div class="panel-hdr">
                    <h2>
                        Returning <span class="fw-300"><i>Target</i></span>
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content poisition-relative">
                        <div
                            class="p-1 position-absolute pos-right pos-top mt-3 mr-3 z-index-cloud d-flex align-items-center justify-content-center">
                            <div
                                class="border-faded border-top-0 border-left-0 border-bottom-0 py-2 pr-4 mr-3 hidden-sm-down">
                                <div class="text-right fw-500 l-h-n d-flex flex-column">
                                    <div class="h3 m-0 d-flex align-items-center justify-content-end">
                                        <div class='icon-stack mr-2'>
                                            <i class="base base-7 icon-stack-3x opacity-100 color-success-600"></i>
                                            <i class="base base-7 icon-stack-2x opacity-100 color-success-500"></i>
                                            <i class="fal fa-arrow-up icon-stack-1x opacity-100 color-white"></i>
                                        </div>
                                        $44.34 / GE
                                    </div>
                                    <span class="m-0 fs-xs text-muted">Increased Profit as per redux margins and
                                        estimates</span>
                                </div>
                            </div>
                            <div class="js-easy-pie-chart color-info-400 position-relative d-inline-flex align-items-center justify-content-center"
                                data-percent="35" data-piesize="95" data-linewidth="10" data-scalelength="5">
                                <div class="js-easy-pie-chart color-success-400 position-relative position-absolute pos-left pos-right pos-top pos-bottom d-flex align-items-center justify-content-center"
                                    data-percent="65" data-piesize="60" data-linewidth="5" data-scalelength="1"
                                    data-scalecolor="#fff">
                                    <div
                                        class="position-absolute pos-top pos-left pos-right pos-bottom d-flex align-items-center justify-content-center fw-500 fs-xl text-dark">
                                        78%</div>
                                </div>
                            </div>
                        </div>
                        <div id="flot-area" style="width:100%; height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="panel-3" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
                <div class="panel-hdr">
                    <h2>
                        Effective <span class="fw-300"><i>Support Form</i></span>
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content poisition-relative">
                        <div class="pb-5 pt-3">
                            <div class="row">
                                <div class="col-6 col-xl-3 d-sm-flex align-items-center">
                                    <div class="p-2 mr-3 bg-info-200 rounded">
                                        <span class="peity-bar"
                                            data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }">3,4,5,8,2</span>
                                    </div>
                                    <div>
                                        <label class="fs-sm mb-0">Bounce Rate</label>
                                        <h4 class="font-weight-bold mb-0">37.56%</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3 d-sm-flex align-items-center">
                                    <div class="p-2 mr-3 bg-info-300 rounded">
                                        <span class="peity-bar"
                                            data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }">5,3,1,7,9</span>
                                    </div>
                                    <div>
                                        <label class="fs-sm mb-0">Sessions</label>
                                        <h4 class="font-weight-bold mb-0">759</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3 d-sm-flex align-items-center">
                                    <div class="p-2 mr-3 bg-success-300 rounded">
                                        <span class="peity-bar"
                                            data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }">3,4,3,5,5</span>
                                    </div>
                                    <div>
                                        <label class="fs-sm mb-0">New Sessions</label>
                                        <h4 class="font-weight-bold mb-0">12.17%</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3 d-sm-flex align-items-center">
                                    <div class="p-2 mr-3 bg-success-500 rounded">
                                        <span class="peity-bar"
                                            data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }">6,4,7,5,6</span>
                                    </div>
                                    <div>
                                        <label class="fs-sm mb-0">Clickthrough</label>
                                        <h4 class="font-weight-bold mb-0">19.77%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="flotVisit" style="width:100%; height:208px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 sortable-grid ui-sortable">
            <div id="panel-4" class="panel panel-sortable" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Users <span class="fw-300"><i>Online</i></span>
                    </h2>
                    <div class="panel-saving mr-2" style="display:none"><i
                            class="fal fa-spinner-third fa-spin-4x fs-xl"></i></div>
                    <div class="panel-toolbar" role="menu"><a href="#"
                            class="btn btn-panel hover-effect-dot js-panel-collapse waves-effect waves-themed"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></a> <a
                            href="#"
                            class="btn btn-panel hover-effect-dot js-panel-fullscreen waves-effect waves-themed"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></a> <a
                            href="#" class="btn btn-panel hover-effect-dot js-panel-close waves-effect waves-themed"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></a></div>
                    <div class="panel-toolbar" role="menu"><a href="#"
                            class="btn btn-toolbar-master waves-effect waves-themed" data-toggle="dropdown"><i
                                class="fal fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-menu-right p-0"><a href="#"
                                class="dropdown-item js-panel-refresh"><span data-i18n="drpdwn.refreshpanel">Refresh
                                    Content</span></a> <a href="#" class="dropdown-item js-panel-locked"><span
                                    data-i18n="drpdwn.lockpanel">Lock Position</span></a>
                            <div class="dropdown-multilevel dropdown-multilevel-left">
                                <div class="dropdown-item"> <span data-i18n="drpdwn.panelcolor">Panel Style</span> </div>
                                <div class="dropdown-menu d-flex flex-wrap"
                                    style="min-width: 9.5rem; width: 9.5rem; padding: 0.5rem"><a href="#"
                                        class="btn d-inline-block bg-primary-700 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-primary-700 bg-success-gradient" style="margin:1px;"></a>
                                    <a href="#"
                                        class="btn d-inline-block bg-primary-500 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-primary-500 bg-info-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-primary-600 bg-primary-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-primary-600 bg-primary-gradient" style="margin:1px;"></a>
                                    <a href="#"
                                        class="btn d-inline-block bg-info-600 bg-primray-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-info-600 bg-primray-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-info-600 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-info-600 bg-info-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-info-700 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-info-700 bg-success-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-success-900 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-success-900 bg-info-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-success-700 bg-primary-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-success-700 bg-primary-gradient" style="margin:1px;"></a>
                                    <a href="#"
                                        class="btn d-inline-block bg-success-600 bg-success-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-success-600 bg-success-gradient" style="margin:1px;"></a>
                                    <a href="#"
                                        class="btn d-inline-block bg-danger-900 bg-info-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-danger-900 bg-info-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-fusion-400 bg-fusion-gradient width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-fusion-400 bg-fusion-gradient" style="margin:1px;"></a> <a
                                        href="#"
                                        class="btn d-inline-block bg-faded width-2 height-2 p-0 rounded-0 js-panel-color hover-effect-dot waves-effect waves-themed"
                                        data-panel-setstyle="bg-faded" style="margin:1px;"></a></div>
                            </div>
                            <div class="dropdown-divider m-0"></div>
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
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $item)
                                                    <tr role="row" class="odd">
                                                        <td class="sorting_1" tabindex="0">
                                                            <img src="{{asset('admins/img/demo/avatars/avatar-m.png')}}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 36px;height: 36px;">
                                                        </td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->email}}</td>
                                                        <td>{{$item->user}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->branch_name_en}}</td>
                                                        <td>{{$item->dt}}</td>
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

        <div class="col-xl-12">
            <div id="panel-12" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Titcke <span class="fw-300"><i>Status</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-xl-5">
                                <div id="js-pie-options" class="w-100" style="height: 250px; padding: 0px; position: relative;">
                                    <canvas class="flot-base" width="586" height="312" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 469.5px; height: 250px;"></canvas>
                                    <canvas class="flot-overlay" width="586" height="312" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 469.5px; height: 250px;"></canvas>
                                    <div class="legend">
                                        <div style="position: absolute; width: 88.675px; height: 107.55px; top: 5px; right: 5px; background-color: rgb(255, 255, 255); opacity: 0.85;">
                                        </div>
                                        <table style="position:absolute;top:5px;right:5px;;font-size:smaller;color:#545454">
                                            <tbody>
                                                <tr>
                                                    <div style="border:1px solid #ccc;padding:1px">
                                                        <div style="width:4px;height:0;border:5px solid #fd3995;overflow:hidden"></div>
                                                    </div>
                                                    <td class="legendLabel">New</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #2196f3;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">Waiting Reply</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #ffc241;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">Replied</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #886ab5;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">In Progress</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #1dc9b7;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">On Hold</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #5d5d5d;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">Fixed</td>
                                                </tr>
                                                <tr>
                                                    <td class="legendColorBox">
                                                        <div style="border:1px solid #ccc;padding:1px">
                                                            <div style="width:4px;height:0;border:5px solid #5d5d5d;overflow:hidden"></div>
                                                        </div>
                                                    </td>
                                                    <td class="legendLabel">Resolved</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 offset-xl-1">
                                <div class="h-100 d-flex align-items-center mt-3 mt-xl-0">
                                    <div class="demo">
                                        <button id="example-1"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Default
                                            Options</button>
                                        <button id="example-2"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Without
                                            Legend</button>
                                        <button id="example-3"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Label
                                            Formatter</button>
                                        <button id="example-4"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Label
                                            Radius</button>
                                        <button id="example-5"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Label
                                            Styles #1</button>
                                        <button id="example-6"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Label
                                            Styles #2</button>
                                        <button id="example-7"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Hidden
                                            Labels</button>
                                        <button id="example-8"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Combined
                                            Slice</button>
                                        <button id="example-9"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Rectangular
                                            Pie</button>
                                        <button id="example-10"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Tilted
                                            Pie</button>
                                        <button id="example-11"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Donut
                                            Hole</button>
                                        <button id="example-12"
                                            class="btn btn-outline-primary js-pie-example waves-effect waves-themed">Interactivity</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@include('includs.datatable_basic')
    <script>
        $(function() {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/dashboad/show') }}",
                data: "data",
                dataType: "JSON",
                success: function(response) {
                    // console.log(response.priorities);
                    let dataPriorities = response.priorities;
                    if (response.dataTickets.length > 0) {
                        var newTicket = 0;
                        var priority = 0;
                        var assign = 0;
                        var tickeActive = 0;
                        dataPriorities.map((element) => {
                            console.log(element);
                        });
                        response.dataTickets.map((item) => {
                            if (item.status == 1) {
                                newTicket++;
                            }
                            if (item.priority == 1) {
                                priority++;
                            }
                            if (item.owner == 1) {
                                assign++;
                            } 
                            
                            if(item.status) {
                                tickeActive++;
                            }
                        });
                        $('#total-new-ticket').text(newTicket);
                        $('#total-priority').text(priority);
                        $('#total-assign').text(assign);
                        $('#total-ticke-active').text(tickeActive);
                    }
                    let dataTicketStatus = {
                        dataTickets: response.dataTickets,
                        customStatuses: response.customStatuses,
                    }
                    TicketStatus(dataTicketStatus);
                }
            });
        });
        /* defined datas */
        var dataTargetProfit = [
            [1354586000000, 153],
            [1364587000000, 658],
            [1374588000000, 198],
            [1384589000000, 663],
            [1394590000000, 801],
            [1404591000000, 1080],
            [1414592000000, 353],
            [1424593000000, 749],
            [1434594000000, 523],
            [1444595000000, 258],
            [1454596000000, 688],
            [1464597000000, 364]
        ]
        var dataProfit = [
            [1354586000000, 53],
            [1364587000000, 65],
            [1374588000000, 98],
            [1384589000000, 83],
            [1394590000000, 980],
            [1404591000000, 808],
            [1414592000000, 720],
            [1424593000000, 674],
            [1434594000000, 23],
            [1444595000000, 79],
            [1454596000000, 88],
            [1464597000000, 36]
        ]
        var dataSignups = [
            [1354586000000, 647],
            [1364587000000, 435],
            [1374588000000, 784],
            [1384589000000, 346],
            [1394590000000, 487],
            [1404591000000, 463],
            [1414592000000, 479],
            [1424593000000, 236],
            [1434594000000, 843],
            [1444595000000, 657],
            [1454596000000, 241],
            [1464597000000, 341]
        ]
        var dataSetBar1 = [
            [0, 3],
            [2, 8],
            [4, 5],
            [6, 13],
            [8, 5],
            [10, 7],
            [12, 4],
            [14, 6]
        ];
        var dataSetBar2 = [
            [0, 3],
            [2, 8],
            [4, 5],
            [6, 13],
            [8, 5],
            [10, 7],
            [12, 8],
            [14, 10]
        ];
        var dataSetBar3 = [
            [1, 5],
            [3, 7],
            [5, 10],
            [7, 7],
            [9, 9],
            [11, 5],
            [13, 4],
            [15, 6]
        ];
        var dataSet1 = [
            [0, 2],
            [1, 3],
            [2, 6],
            [3, 5],
            [4, 7],
            [5, 8],
            [6, 10]
        ];
        var dataSet2 = [
            [0, 1],
            [1, 2],
            [2, 5],
            [3, 3],
            [4, 5],
            [5, 6],
            [6, 9]
        ];
        var dataSet3 = [
            [0, 10],
            [1, 7],
            [2, 8],
            [3, 9],
            [4, 6],
            [5, 5],
            [6, 7]
        ];
        var dataSet4 = [
            [0, 8],
            [1, 5],
            [2, 6],
            [3, 8],
            [4, 4],
            [5, 3],
            [6, 6]
        ];

        function TicketStatus(datas){
            // console.log(datas.dataTickets);
            let totalNew = 0;
            let totalWaitingReply = 0;
            let totalReplied = 0;
            let totalInProgress = 0;
            let tatalOnHold = 0;
            let totalFixed = 0;
            let totalResolved = 0;
            if (datas.dataTickets.length>0) {
                datas.dataTickets.map((item)=>{
                    if (item.status==1) {
                        totalNew++;
                    }
                    if(item.status==2){
                        totalWaitingReply++;
                    }
                    if(item.status==3){
                        totalReplied++;
                    }
                    if(item.status==4){
                        totalInProgress++;
                    } 
                    if(item.status==5){
                        tatalOnHold++;
                    }
                    if(item.status==6){
                        totalFixed++;
                    }
                    if(item.status==7){
                        totalResolved++;   
                    }
                });
            }
            // console.log(datas.customStatuses);
            // let dataSetPie = [];
            // datas.customStatuses.map((item)=>{
            //     console.log(item);
            //     dataSetPie.push(
            //         {
            //             label: item.name,
            //             data: totalNew,
            //             color: item.color
            //         }
            //     )
            // });
            var dataSetPie = [
                {
                    label: "New",
                    data: totalNew,
                    color: color.danger._500
                },
                {
                    label: "Waiting Reply",
                    data: totalWaitingReply,
                    color: color.warning._500
                },
                {
                    label: "Replied",
                    data: totalReplied,
                    color: color.info._500
                },
                {
                    label: "In Progress",
                    data: totalInProgress,
                    color: color.primary._500
                },
                {
                    label: "On Hold",
                    data: tatalOnHold,
                    color: color.success._500
                },
                {
                    label: "Fixed",
                    data: totalFixed,
                    color: color.fusion._400
                },
                {
                    label: "Resolved",
                    data: totalResolved,
                    color: color.success._500
                }
            ];
            
            // target 
            var placeholder = $("#js-pie-options");
            /* init first plot */
            $.plot(placeholder, dataSetPie, {
                series: {
                    pie: {
                        show: true
                    }
                },
                legend: {
                    show: true
                }
            });
            //buttons
            $(document).on('click', '.js-pie-example', function() {
                $("#js-pie-options").unbind();
                var id = this.id;
                $(".js-pie-example").removeClass("active");
                $("#" + id).addClass("active");
                switch (true) {
                    case (id == "example-1"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Chart (default)</span>');
                        $("#panel-12 .panel-tag").text("The default pie chart with no options set");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true
                                }
                            }
                        });
                        break;
                    case (id == "example-2"):
                        // code block
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Chart (legend)</span>');
                        $("#panel-12 .panel-tag").text("The default pie chart when the legend is disabled. Since the labels would normally be outside the container, the chart is resized to fit");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-3"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Custom Label Formatter</span>');
                        $("#panel-12 .panel-tag").text("Added a semi-transparent background to the labels and a custom labelFormatter function");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    label: {
                                        show: true,
                                        radius: 1,
                                        formatter: labelFormatter,
                                        background: {
                                            opacity: 0.8
                                        }
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-4"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Label Radius</span>');
                        $("#panel-12 .panel-tag").html("Slightly more transparent label backgrounds and adjusted the radius values to place them within the pie <code>radius: 3 / 4</code>");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    label: {
                                        show: true,
                                        radius: 3 / 4,
                                        formatter: labelFormatter,
                                        background: {
                                            opacity: 0.5
                                        }
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-5"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Label Styles #1</span>');
                        $("#panel-12 .panel-tag").html("Semi-transparent, black-colored label background");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    label: {
                                        show: true,
                                        radius: 3 / 4,
                                        formatter: labelFormatter,
                                        background: {
                                            opacity: 0.5,
                                            color: "#000"
                                        }
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-6"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Label Styles #2</span>');
                        $("#panel-12 .panel-tag").html("Semi-transparent, black-colored label background placed at pie edge");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 3 / 4,
                                    label: {
                                        show: true,
                                        radius: 3 / 4,
                                        formatter: labelFormatter,
                                        background: {
                                            opacity: 0.5,
                                            color: "#000"
                                        }
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-7"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Hidden Labels</span>');
                        $("#panel-12 .panel-tag").html("Labels can be hidden if the slice is less than a given percentage of the pie (10% in this case)");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    label: {
                                        show: true,
                                        radius: 2 / 3,
                                        formatter: labelFormatter,
                                        threshold: 0.1
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-8"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Combined Slice</span>');
                        $("#panel-12 .panel-tag").html("Multiple slices less than a given percentage (5% in this case) of the pie can be combined into a single, larger slice");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    combine: {
                                        color: "#999",
                                        threshold: 0.05
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-9"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Rectangular Pie</span>');
                        $("#panel-12 .panel-tag").html("The radius can also be set to a specific size (even larger than the container itself)");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 500,
                                    label: {
                                        show: true,
                                        formatter: labelFormatter,
                                        threshold: 0.1
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-10"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Tilted Pie</span>');
                        $("#panel-12 .panel-tag").html("The pie can be tilted at an angle");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    tilt: 0.5,
                                    label: {
                                        show: true,
                                        radius: 1,
                                        formatter: labelFormatter,
                                        background: {
                                            opacity: 0.8
                                        }
                                    },
                                    combine: {
                                        color: "#999",
                                        threshold: 0.1
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                        break;
                    case (id == "example-11"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Donut Hole</span>');
                        $("#panel-12 .panel-tag").html("A donut hole can be added");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true
                                }
                            }
                        });
                        break;
                    case (id == "example-12"):
                        $("#panel-12 h2").html('Titcke <span class="fw-300 font-italic">Interactivity</span>');
                        $("#panel-12 .panel-tag").html("The pie can be made interactive with hover and click events");
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true
                                }
                            }
                        });
                        $.plot(placeholder, dataSetPie, {
                            series: {
                                pie: {
                                    show: true
                                }
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            }
                        });

                        placeholder.bind("plothover", function(event, pos, obj) {

                            if (!obj) {
                                return;
                            }
                            var percent = parseFloat(obj.series.percent).toFixed(2);
                            $("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" +percent + "%)</span>");
                        });

                        placeholder.bind("plotclick", function(event, pos, obj) {

                            if (!obj) {
                                return;
                            }

                            percent = parseFloat(obj.series.percent).toFixed(2);
                            alert("" + obj.series.label + ": " + percent + "%");
                        });
                    break;
                }
            });
        }

       
        var data = [], totalPoints = 50;
        var plotRealtimeCurvedInterval = 1000;
        var plotRealtimeFillInterval = 1000;

        /* generate random data */
        var getRandomData = function() {
            if (data.length > 0)
                data = data.slice(1);
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;
                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }
                data.push(y);
            }
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }
            return res;
        }
        /* generate random data -- end */

        /* label formatter */
        var labelFormatter = function(label, series) {
            return "<div class='fs-xs text-center p-1 text-white'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
        /* label formatter -- end */

        /* init() interval range */
        $(document).on('change', '.js-set-interval', function() {
            plotRealtimeFillInterval = Math.abs($('#js-flot-realtime-fill-speed').val());
            plotRealtimeCurvedInterval = Math.abs($('#js-flot-realtime-curved-speed').val());
        })

        $(document).ready(function() {
            /* flot bar */
            var flotBar = $.plot("#flot-bar", [{
                data: [
                    [0, 3],
                    [2, 8],
                    [4, 5],
                    [6, 13],
                    [8, 5],
                    [10, 7],
                    [12, 4],
                    [14, 6]
                ]
            }], {
                series: {
                    bars: {
                        show: true,
                        lineWidth: 0,
                        fillColor: color.fusion._200
                    }
                },
                grid: {
                    borderWidth: 1,
                    borderColor: '#eee'
                },
                yaxis: {
                    tickColor: '#eee',
                    font: {
                        color: '#999',
                        size: 10
                    }
                },
                xaxis: {
                    tickColor: '#eee',
                    font: {
                        color: '#999',
                        size: 10
                    }
                }
            });
            /* flot bar lines -- end */

            /* flot bar lines multiple */
            var flotBarFill = $.plot("#flot-bar-fill", [{
                    data: [
                        [0, 3],
                        [2, 8],
                        [4, 5],
                        [6, 13],
                        [8, 5],
                        [10, 7],
                        [12, 8],
                        [14, 10]
                    ],
                    bars: {
                        show: true,
                        lineWidth: 0,
                        fillColor: color.success._500
                    }
                },
                {
                    data: [
                        [1, 5],
                        [3, 7],
                        [5, 10],
                        [7, 7],
                        [9, 9],
                        [11, 5],
                        [13, 4],
                        [15, 6]
                    ],
                    bars: {
                        show: true,
                        lineWidth: 0,
                        fillColor: color.primary._500
                    }
                }
            ], {
                grid: {
                    borderWidth: 1,
                    borderColor: '#D9D9D9'
                },
                yaxis: {
                    tickColor: '#d9d9d9',
                    font: {
                        color: '#666',
                        size: 10
                    }
                },
                xaxis: {
                    tickColor: '#d9d9d9',
                    font: {
                        color: '#666',
                        size: 10
                    }
                }
            });
            /* flot bar lines multiple -- end */

            /* flot simple lines */
            var flotLine = $.plot($('#flot-line'), [{
                    data: dataSet1,
                    label: 'New Customer',
                    color: color.primary._400
                },
                {
                    data: dataSet2,
                    label: 'Returning Customer',
                    color: color.fusion._400
                }
            ], {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 1
                    },
                    shadowSize: 0
                },
                points: {
                    show: false,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot simple lines -- end */

            /* flot lines curved */
            var flotLineCurves = $.plot($('#flot-line-curves'), [{
                    data: dataSet1,
                    label: 'New Customer',
                    color: color.primary._400
                },
                {
                    data: dataSet2,
                    label: 'Returning Customer',
                    color: color.fusion._400
                }
            ], {
                series: {
                    lines: {
                        show: false
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        //fill: 0.4
                    },
                    shadowSize: 0
                },
                points: {
                    show: false,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot lines curved -- end */

            /* flot lines tooltip */
            var flotLineAlt = $.plot($('#flot-line-alt'), [{
                    data: dataSet3,
                    label: 'New Customer',
                    color: color.danger._500
                },
                {
                    data: dataSet4,
                    label: 'Returning Customer',
                    color: color.success._500
                }
            ], {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 1
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                tooltip: true,
                tooltipOpts: {
                    cssClass: 'tooltip-inner',
                    defaultTheme: false,
                    shifts: {
                        x: 10,
                        y: -40
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot lines tooltip -- end */

            /* flot lines curved tooltip */
            var flotLineCurvesAlt = $.plot($('#flot-line-curves-alt'), [{
                    data: dataSet3,
                    label: 'New Customer',
                    color: color.danger._500
                },
                {
                    data: dataSet4,
                    label: 'Returning Customer',
                    color: color.success._500
                }
            ], {
                series: {
                    lines: {
                        show: false
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        //fill: 0.4
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                tooltip: true,
                tooltipOpts: {
                    cssClass: 'tooltip-inner',
                    defaultTheme: false,
                    shifts: {
                        x: 10,
                        y: -40
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot lines curved tooltip -- end */

            /* flot area */
            var flotArea = $.plot($('#flot-area'), [{
                    data: dataSet1,
                    label: 'New Customer',
                    color: color.primary._500
                },
                {
                    data: dataSet2,
                    label: 'Returning Customer',
                    color: color.fusion._500
                }
            ], {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 0,
                        fill: 0.8
                    },
                    shadowSize: 0
                },
                points: {
                    show: false,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot area -- end */

            /* flot area fill */
            var flotAreaFill = $.plot($('#flot-area-fill'), [{
                    data: dataSet1,
                    label: 'New Customer',
                    color: color.primary._500
                },
                {
                    data: dataSet2,
                    label: 'Returning Customer',
                    color: color.fusion._500
                }
            ], {
                series: {
                    lines: {
                        show: false
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 0,
                        fill: 0.8
                    },
                    shadowSize: 0
                },
                points: {
                    show: false,
                },
                legend: {
                    noColumns: 1,
                    position: 'nw'
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot area fill -- end */

            /* flot realtime curved */
            var plotRealtimeCurved = $.plot('#flot-realtime-curved', [getRandomData()], {
                colors: [color.primary._500],
                series: {
                    lines: {
                        show: false
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        //fill: 0.9
                    },
                    shadowSize: 0 // Drawing is faster without shadows
                },
                grid: {
                    borderColor: '#ddd',
                    borderWidth: 1,
                    labelMargin: 5
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot realtime curved -- end */

            /* flot realtime fill */
            var plotRealtimeFill = $.plot('#flot-realtime-fill', [getRandomData()], {
                colors: [color.primary._200],
                series: {
                    lines: {
                        show: true,
                        lineWidth: 0,
                        fill: 0.9
                    },
                    shadowSize: 0 // Drawing is faster without shadows
                },
                grid: {
                    borderColor: '#ddd',
                    borderWidth: 1,
                    labelMargin: 5
                },
                xaxis: {
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    color: '#eee',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            });
            /* flot realtime fill -- end */

            /* generate realtime data */
            var updateRealtimeCurved = function() {
                plotRealtimeCurved.setData([getRandomData()]);
                plotRealtimeCurved.draw();
                setTimeout(updateRealtimeCurved, plotRealtimeCurvedInterval);
            }
            var updateRealtimeFill = function() {
                plotRealtimeFill.setData([getRandomData()]);
                plotRealtimeFill.draw();
                setTimeout(updateRealtimeFill, plotRealtimeFillInterval);
            }
            /* generate realtime data -- end */
            updateRealtimeCurved();
            updateRealtimeFill();

            /* flot toggle example */
            var flot_toggle = function() {

                var data = [{
                        label: "Target Profit",
                        data: dataTargetProfit,
                        color: color.danger._500,
                        bars: {
                            show: true,
                            align: "center",
                            barWidth: 30 * 30 * 60 * 1000 * 80,
                            lineWidth: 0,
                            fillColor: {
                                colors: [color.danger._900, color.danger._100]
                            }
                        },
                        highlightColor: 'rgba(255,255,255,0.3)',
                        shadowSize: 0
                    },
                    {
                        label: "Actual Profit",
                        data: dataProfit,
                        color: color.info._500,
                        lines: {
                            show: true,
                            lineWidth: 5
                        },
                        shadowSize: 0,
                        points: {
                            show: true
                        }
                    },
                    {
                        label: "User Signups",
                        data: dataSignups,
                        color: color.success._500,
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0,
                        points: {
                            show: true
                        }
                    }
                ]

                var options = {
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: '#f2f2f2',
                        borderWidth: 1,
                        borderColor: '#f2f2f2'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        cssClass: 'tooltip-inner',
                        defaultTheme: false
                    },
                    xaxis: {
                        mode: "time"
                    },
                    yaxes: {
                        tickFormatter: function(val, axis) {
                            return "$" + val;
                        },
                        max: 1200
                    }
                };

                var plot2 = null;

                function plotNow() {
                    var d = [];
                    $("#js-checkbox-toggles").find(':checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            d.push(data[$(this).attr("name").substr(4, 1)]);
                        }
                    });
                    if (d.length > 0) {
                        if (plot2) {
                            plot2.setData(d);
                            plot2.draw();
                        } else {
                            plot2 = $.plot($("#flot-toggles"), d, options);
                        }
                    }
                };

                $("#js-checkbox-toggles").find(':checkbox').on('change', function() {
                    plotNow();
                });
                plotNow()
            }
            flot_toggle();
            /* flot toggle example -- end*/

        });
    </script>
@endsection

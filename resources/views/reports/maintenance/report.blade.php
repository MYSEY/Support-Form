@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row filter-btn">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="" placeholder="From Date">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="To Date">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="staff_name" id="staff_name" value="" placeholder="Staff Name">
                            </div>
                        </div>
                       
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed" id="btnSearch">Search</a>
                            @if (Auth::user()->can('Maintenance Report Export'))
                                <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                            @endif
                            @if (Auth::user()->can('Maintenance Report Export'))
                                <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed mr-1" id="btnDownloadExcel" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Download</span></a>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row filter-btn mb-4">
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <select class="select2 form-control w-100 select2-hidden-accessible" id="serial" data-select2-id="select2-data-2-c0n2" name="serial">
                                    <option value="">-- Select serial --</option>
                                    @foreach ($serial as $key => $item)
                                        <option value="{{$item->serial}}">{{$item->serial}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="office" id="office">
                                    <option value="">-- Select Office --</option>
                                    @foreach ($office as $key => $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="department_id" id="department_id">
                                    <option value="">-- Select Department --</option>
                                    @foreach ($department as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="maintenance_mission" id="maintenance_mission">
                                    <option value="">-- Select Maintenance Type --</option>
                                    @foreach ($maintenanceMission as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintenance Report
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="tbl_maintenace_report" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>MaintenanceDate</th>
                                        <th>Technician</th>
                                        <th>Serial</th>
                                        <th>Category</th>
                                        <th>Device_Name</th>
                                        <th>Office</th>
                                        <th>Department</th>
                                        <th>Location</th>
                                        <th>End_User</th>
                                        <th>Postion</th>
                                        <th>MaintenanceType</th>
                                        <th>Created_At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let from_date = null;
        let to_date = null;
        let staff_name = null;
        var detail = @json(Auth::user()->can('Maintenance Report Detail'));
        $(document).ready(function(){
            $('#btnSearch').on('click', function() {
                from_date = $('#from_date').val();
                to_date = $('#to_date').val();
                staff_name = $('#staff_name').val();
                let serial = $('select[name="serial"]').val();
                let office = $('select[name="office"]').val();
                let department_id = $('select[name="department_id"]').val();
                let maintenance_mission = $('select[name="maintenance_mission"]').val();
                $('#tbl_maintenace_report').DataTable().ajax.reload();
            });
            dataTables();
            $('#btn-export').on('click',function(){
                let query = {
                    from_date: $("#from_date").val(),
                    to_date: $("#to_date").val(),
                    staff_name: $("#staff_name").val(),
                    serial: $("#serial").val(),
                    office: $("#office").val(),
                    department_id: $("#department_id").val(),
                    maintenance_mission: $("#maintenance_mission").val(),
                };
                var url = "{{URL::to('admin/report/maintenance/export')}}?" + $.param(query)
                window.location = url;
            });
            $('#btnDownloadExcel').on('click',function(){
                let query = {
                    from_date: $("#from_date").val(),
                    to_date: $("#to_date").val(),
                    staff_name: $("#staff_name").val(),
                    serial: $("#serial").val(),
                    office: $("#office").val(),
                    department_id: $("#department_id").val(),
                    maintenance_mission: $("#maintenance_mission").val(),
                };
                var url = "{{URL::to('admin/report/maintenance/download/excel')}}?" + $.param(query)
                window.location = url;
            });
        });
        function dataTables() {
            $('#tbl_maintenace_report').DataTable({
                // dom: 'Blfrtip',
                pageLength: 10,
                destroy: true,
                processing: true,
                serverSide: true,
                scrollX: true,
                scrollY: '500px',
                scroller: false,
                order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/report/maintenance") }}',
                    type: 'GET',
                    data: function(d) {
                        d.from_date = from_date;
                        d.to_date = to_date;
                        d.staff_name = staff_name;
                        d.serial = $('select[name="serial"]').val();
                        d.office = $('select[name="office"]').val();
                        d.department_id = $('select[name="department_id"]').val();
                        d.maintenance_mission = $('select[name="maintenance_mission"]').val();
                    }
                },
                columns: [
                    {
                        data: 'maintenance_date',
                        name: 'maintenance_date',
                    },
                    {
                        data: 'maintenace_by',
                        name: 'maintenace_by',
                    },
                    {
                        data: 'serial',
                        name: 'serial',
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                    },
                    {
                        data: 'device_name',
                        name: 'device_name',
                    },
                    {
                        data: 'branch_name_en',
                        name: 'branch_name_en',
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                    },
                    {
                        data: 'location',
                        name: 'location',
                    },
                    {
                        data: 'employee_name_en',
                        name: 'employee_name_en',
                    },
                    {
                        data: 'name_english',
                        name: 'name_english',
                    },
                    {
                        data: 'maintenance_mission',
                        name: 'maintenance_mission',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            let buttons = '';
                            if (row.id) {
                                if (detail) {
                                    return `<a href="{{url('/admin/maintenance/history/')}}/${row.asset_id}" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" title="Detail"><i class="fal fa-eye"></i></a>`;
                                }
                            }
                            return buttons || '';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[0, 'desc']]
            });
        }
    </script>
@endsection

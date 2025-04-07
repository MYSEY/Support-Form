@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row filter-btn">
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="maintenance_date" id="maintenance_date" value="" placeholder="Maintenance Date">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="staff_name" id="staff_name" value="" placeholder="Staff Name">
                            </div>
                        </div>
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
                                    <option value="">-- Select office --</option>
                                    @foreach ($office as $key => $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed" id="btnSearch">Search</a>
                            @can('Ticket Report Export')
                                <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                            @endcan
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
                                        <th>Location</th>
                                        <th>End_User</th>
                                        <th>Postion</th>
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
        let maintenance_date = null;
        let staff_name = null;
        $(document).ready(function(){
            $('#btnSearch').on('click', function() {
                maintenance_date = $('#maintenance_date').val();
                staff_name = $('#staff_name').val();
                let serial = $('select[name="serial"]').val();
                let office = $('select[name="office"]').val();
                $('#tbl_maintenace_report').DataTable().ajax.reload();
            });
            dataTables();
            $('#btn-export').on('click',function(){
                let query = {
                    maintenance_date: $("#maintenance_date").val(),
                    staff_name: $("#staff_name").val(),
                    serial: $("#serial").val(),
                    office: $("#office").val()
                };
                var url = "{{URL::to('admin/report/maintanance/export')}}?" + $.param(query)
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
                order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/report/maintanance") }}',
                    type: 'GET',
                    data: function(d) {
                        d.maintenance_date = maintenance_date;
                        d.staff_name = staff_name;
                        d.serial = $('select[name="serial"]').val();
                        d.office = $('select[name="office"]').val();
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
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            return `<a href="/admin/maintenance/${row.id}" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" title="Detail"><i class="fal fa-eye"></i></a>`;
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

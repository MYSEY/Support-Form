@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row filter-btn">
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="" placeholder="Resign Date From">
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="Resign Date To">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect btn-sm waves-themed" id="btnSearch">Search</a>
                            @can('Staff Resign Report Export')
                                <a href="javascript:void(0)" class="btn btn-outline-success btn-sm waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                            @endcan
                            <a href="javascript:void(0)" class=""><span class="btn btn-outline-danger btn-sm btn-reset">Reset</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Staff Resigned
                </h2>
            </div>
            
            <div class="panel-container show">
                <div class="panel-content">
                    <table id="tbl_staff_resign_report" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>StaffID</th>
                                <th>Name_KH</th>
                                <th>Name_En</th>
                                <th>Position_KH</th>
                                <th>Position_En</th>
                                <th>Location</th>
                                <th>Department</th>
                                <th>Resign_Date</th>
                                <th>Last_Update</th>
                                <th>Export_Date</th>
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
@endsection
@section('script')
    <script>
        let from_date = null;
        let to_date = null;
        $(document).ready(function(){
            dataTables();
            $('.btn-reset').on('click', function() {
                $('#to_date').val('');
                $('#from_date').val('');
            });
            $('#btnSearch').on('click', function() {
                from_date = $('#from_date').val();
                to_date = $('#to_date').val();
                $('#tbl_staff_resign_report').DataTable().ajax.reload();
            });

            $('#btn-export').on('click',function(){
                let query = {};
                var url = "{{URL::to('admin/report/staff/resign/export')}}?" + $.param(query)
                window.location = url;
            });
            
        });

        function dataTables() {
            $('#tbl_staff_resign_report').DataTable({
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
                    url: '{{ URL("admin/report/staff/resign") }}',
                    type: 'GET',
                    data: function(d) {
                        d.from_date = from_date;
                        d.to_date = to_date;
                    }
                },
                columns: [
                    { data: 'number_employee', name: 'number_employee' },
                    { data: 'employee_name_kh', name: 'employee_name_kh' },
                    { data: 'employee_name_en', name: 'employee_name_en' },
                    { data: 'name_khmer', name: 'name_khmer' },
                    { data: 'name_english', name: 'name_english' },
                    { data: 'branch_name_en', name: 'branch_name_en' },
                    { data: 'depart_name', name: 'depart_name' },
                    {
                        data: 'resign_date',
                        name: 'resign_date',
                        render: function(data, type, row) {
                            return `${moment(row.resign_date).format('D-MMM-YYYY')}`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type, row) {
                            const updated_at = row.updated_at ? moment(row.updated_at).format('D-MMM-YYYY hh:mm A') : "";
                           return updated_at
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'export_date',
                        name: 'export_date',
                        render: function(data, type, row) {
                            const export_date = row.export_date ? moment(row.export_date).format('D-MMM-YYYY hh:mm A') : "";
                           return export_date;
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

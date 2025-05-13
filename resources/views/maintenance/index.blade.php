@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintainance 
                    </h2>
                </div>
                
                <div class="panel-container show">
                    @can('Maintenance Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a href="{{url('admin/maintenance/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_maintenace" class="table table-bordered table-hover table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>reference</th>
                                                <th>MaintainanceDate</th>
                                                <th>Technician</th>
                                                <th>Serial</th>
                                                <th>Category</th>
                                                <th>DeviceName</th>
                                                <th>Office</th>
                                                <th>Location</th>
                                                <th>EndUser</th>
                                                <th>Postion</th>
                                                <th>MaintenanceType</th>
                                                <th>CreatedAt</th>
                                                <th style="width: 40%">Action</th>
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
        </div>
    </div>
    <!-- Delete Task Modal -->
    <div class="modal custom-modal fade" id="delete_maintenance" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/maintenance/delete')}}" method="POST">
                            @csrf
                            @method('Delete')
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="float-lg-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger waves-effect waves-themed">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@include('includs.datatable_basic')
    <script>
        var edit = @json(Auth::user()->can('Maintenance Edit'));
        var maintanance_delete = @json(Auth::user()->can('Maintenance Delete'));

        $(function(){
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
            dataTables();
        });
        function dataTables() {
            $('#tbl_maintenace').DataTable({
                // dom: 'Blfrtip',
                pageLength: 10,
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/maintenance") }}',
                    type: 'GET',
                    // data: function(d) {
                    //     d.from_date = from_date;
                    //     d.to_date = to_date;
                    //     d.priority = $('select[name="priority"]').val();
                    //     d.status = $('select[name="status"]').val();
                    //     d.user_id = $('select[name="user_id"]').val();
                    // }
                },
                columns: [
                    {
                        data: 'reference',
                        name: 'reference',
                        render: function(data, type, row) {
                            return `<a href="#" class="your-class">${row.reference}</a>`;
                            // return `<a href="{{url('/admin/ticket/detail')}}/${row.reference}" class="your-class">${row.reference}</a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
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
                            let actionButtons = '';
                            if (maintanance_delete) {
                                actionButtons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-2 btnDelete"  data-toggle="modal" data-target="#delete_maintenance"  title="Delete Record" data-id="${row.id}"><i class="fal fa-times"></i></a>`;
                            }
                            if (edit) {
                                actionButtons += `<a href="{{url('/admin/maintenance')}}/${row.id}/edit" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>`;
                                actionButtons += `<a href="{{url('/admin/maintenance')}}/${row.id}" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" title="Detail"><i class="fal fa-eye"></i></a>`;
                            }
                            return actionButtons;
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
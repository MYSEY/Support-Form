@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row filter-btn">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="serial" id="serial" value="" placeholder="Serial">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="branch_id" id="branch_id">
                                    <option value="">-- Select Branch --</option>
                                    @foreach ($branch as $key => $item)
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
                        <div class="" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect btn-sm waves-themed" id="btnSearch">Search</a>
                            <a href="javascript:void(0)" class=""><span class="btn btn-outline-danger btn-sm btn-reset">Reset</span></a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="" placeholder="From Date">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="To Date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintainance 
                    </h2>
                    @can('Maintenance Accept')
                        <div class="text-lg-right">
                            <a href="javascript:void(0)" class="btn btn-success btn-sm mr-1" id="btnAcept"> Accept</span></a>
                        </div>
                    @endcan
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
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_maintenace" class="table table-bordered table-hover display table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkAll" name="checkAll" id="checkAll" onClick="toggle(this)">
                                                        <label class="custom-control-label" for="checkAll"></label>
                                                    </div>
                                                </th>
                                                <th>Reference</th>
                                                <th>MaintainanceDate</th>
                                                <th>Technician</th>
                                                <th>Serial</th>
                                                <th>Category</th>
                                                <th>DeviceName</th>
                                                <th>Office</th>
                                                <th>Department</th>
                                                <th>Location</th>
                                                <th>EndUser</th>
                                                <th>Postion</th>
                                                <th>MaintenanceType</th>
                                                <th>CreatedAt</th>
                                                <th style="width: 40%">Status</th>
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
        var maintanance_detail = @json(Auth::user()->can('Maintenance Detail'));
        var maintanance_delete = @json(Auth::user()->can('Maintenance Delete'));
        var maintanance_accept = @json(Auth::user()->can('Maintenance Accept'));
        let from_date = '';
        let to_date = '';
        let serial = '';
        let branch_id = '';
        let department_id = '';

        $(document).ready(function(){
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
            $('#btnSearch').on('click', function() {
                from_date = $('#from_date').val();
                to_date = $('#to_date').val();
                serial = $('#serial').val();
                let branch_id = $('select[name="branch_id"]').val();
                let department_id = $('select[name="department_id"]').val();
                $('#tbl_maintenace').DataTable().ajax.reload();
            });
            $('.btn-reset').on('click', function() {
                from_date = '';
                to_date = '';
                serial = '';
                branch_id = '';
                department_id = '';
               // Reset select inputs
                $('select[name="department_id"]').val('').trigger('change');
                $('select[name="branch_id"]').val('').trigger('change');
                $('#serial').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                $('#tbl_maintenace').DataTable().ajax.reload();
            });
            $(document).on('click', '#btnAcept', function() {
                let ids = [];
                $('.sub_chk:checked').each(function() {
                    ids.push($(this).data('id'));
                });
                var maintenance_ids = ids.join(",");
                if(ids.length > 0) {
                    $.confirm({
                        title: 'Accepted',
                        content: 'Are you sure want to accepted this maintenance?',
                        type: "blue",
                        buttons: {
                            submit: {
                                text: 'Submit',
                                btnClass: 'btn-green',
                                action: function () {
                                    // $('#modal-loading').modal('show');
                                    axios.post('{{ URL("admin/maintenance/accept") }}', {
                                        maintenance_ids: maintenance_ids,
                                        status: 'accepted'
                                    })
                                    .then(function (response) {
                                        $('#modal-loading').modal('hide');
                                        if (response.data.success) {
                                            new Noty({
                                                text: 'The process has been successfully',
                                                type: "success",
                                                timeout: 2500
                                            }).show();
                                            window.location.replace("{{ URL('admin/maintenance') }}");
                                            return;
                                        } else {
                                            new Noty({
                                                text: 'Something went wrong please try again later',
                                                type: "error",
                                                timeout: 3000
                                            }).show();
                                        }
                                    }).catch(function (error) {
                                        $('#modal-loading').modal('hide');
                                        new Noty({
                                            text: 'Something went wrong please try again later',
                                            type: "error",
                                            timeout: 3000
                                        }).show();
                                    });
                                }
                            },
                            cancel: {
                                text: 'Cancel',
                                btnClass: 'btn-secondary btn-sm'
                            }
                        }
                    });
                } else {
                    new Noty({
                        text: 'Please select at least one record',
                        type: "warning",
                        timeout: 3000
                    }).show();
                }
            });
            $(document).on('change', '.changeStatus', function () {
                let status = $(this).val();
                let id = $(this).data('id');
                $.confirm({
                    title: 'Accepted',
                    content: 'Are you sure want to accepted this maintenance?',
                    type: "blue",
                    buttons: {
                        submit: {
                            text: 'Submit',
                            btnClass: 'btn-green',
                            action: function () {
                                // $('#modal-loading').modal('show');
                                axios.post('{{ URL("admin/maintenance/change-status") }}', {
                                    id: id,
                                    status: status
                                })
                                .then(function (response) {
                                    $('#modal-loading').modal('hide');
                                    if (response.data.success) {
                                        new Noty({
                                            text: 'The process has been successfully',
                                            type: "success",
                                            timeout: 2500
                                        }).show();
                                        window.location.replace("{{ URL('admin/maintenance') }}");
                                        return;
                                    } else {
                                        new Noty({
                                            text: 'Something went wrong please try again later',
                                            type: "error",
                                            timeout: 3000
                                        }).show();
                                    }
                                }).catch(function (error) {
                                    $('#modal-loading').modal('hide');
                                    new Noty({
                                        text: 'Something went wrong please try again later',
                                        type: "error",
                                        timeout: 3000
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm'
                        }
                    }
                });
            });
            $('.checkAll').on('click', function(e) {
                if($(this).is(':checked',true)){
                    $(".sub_chk:not(:disabled)").prop("checked", true);
                } else {
                    $(".sub_chk:not(:disabled)").prop("checked", false);
                }
            });
            
            dataTables();
        });
        function toggle(source) {
            checkboxes = $('.checkAll');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        function dataTables() {
            $('#tbl_maintenace').DataTable({
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
                    url: '{{ URL("admin/maintenance") }}',
                    type: 'GET',
                    data: function(d) {
                        d.from_date = from_date;
                        d.to_date = to_date;
                        d.serial = serial;
                        d.branch_id = $('select[name="branch_id"]').val();
                        d.department_id = $('select[name="department_id"]').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let disabledAttr = "";
                            if (row.status == "accepted") {
                                disabledAttr = "disabled";
                            }
                            return `<div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                <input type="checkbox" class="custom-control-input sub_chk" name="checkbox" data-status="${row.status}" data-id="${data}" id="${data}" value="${data}" ${disabledAttr}>
                                <label class="custom-control-label" for="${data}"></label>
                            </div>`;
                        }
                    },
                    {
                        data: 'reference',
                        name: 'reference',
                        className: 'stuck-scroll-4',
                        render: function(data, type, row) {
                            return `<a href="#" class="your-class">${row.reference == null ? "" : row.reference}</a>`;
                            // return `<a href="{{url('/admin/ticket/detail')}}/${row.reference}" class="your-class">${row.reference == null ? "" : row.reference}</a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'maintenance_date',
                        name: 'maintenance_date',
                        className: 'stuck-scroll-4',
                    },
                    {
                        data: 'maintenace_by',
                        name: 'maintenace_by',
                        className: 'stuck-scroll-4',
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
                        render: function(data, type, row) {
                            return data ? moment(data).format('DD-MM-YYYY') : '';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if(maintanance_accept) {
                                if(row.status == 'accepted') {
                                    return `<span class="badge badge-success">Accepted</span>`;
                                } else if(row.status == 'pending') {
                                    return `
                                        <select class="form-control changeStatus" data-id="${row.id}">
                                            <option value="pending" ${row.status == 'pending' ? 'selected' : ''}>Pending</option>
                                            <option value="accepted" ${row.status == 'accepted' ? 'selected' : ''}>Accepted</option>
                                        </select>
                                    `;
                                } else {
                                    return `<span class="badge badge-secondary">${row.status}</span>`;
                                }
                            }else {
                                return `<span class="badge badge-secondary">${row.status}</span>`;
                            }
                        }
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            let actionButtons = '';
                            if (maintanance_delete) {
                                actionButtons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-2 btnDelete" data-toggle="modal" data-target="#delete_maintenance"  title="Delete Record" data-id="${row.id}"><i class="fal fa-times"></i></a>`;
                            }
                            if (edit) {
                                actionButtons += `<a href="{{url('/admin/maintenance')}}/${row.id}/edit" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-2" title="Edit"><i class="fal fa-edit"></i></a>`;
                            }
                            if (maintanance_detail) {
                                actionButtons += `<a href="{{url('/admin/maintenance')}}/${row.id}" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-2" title="Detail"><i class="fal fa-eye"></i></a>`;
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
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
                </div>
            </div>

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Asset 
                    </h2>
                </div>
                
                <div class="panel-container show">
                    @can('Asset Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                @can('Asset Import')
                                    <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1"><i class="fal fa-file"></i> Import</a>
                                @endcan
                                <a href="{{url('admin/asset/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th width="100%">Serial</th>
                                        <th>Category</th>
                                        <th>DeviceName</th>
                                        <th>Office</th>
                                        <th>Department</th>
                                        <th>Location</th>
                                        <th>EndUser</th>
                                        <th>Postion</th>
                                        <th>AssetDate</th>
                                        <th>Lifecycle(Month)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Task Modal -->
    <div class="modal custom-modal fade" id="delete_asset" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/asset/delete')}}" method="POST">
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
    @include('asset.import')
@endsection

@section('script')
@include('includs.datatable_basic')
    <script>
        var edit = @json(Auth::user()->can('Asset Edit'));
        var assetDelete = @json(Auth::user()->can('Asset Delete'));
        let serial = '';
        let branch_id = '';
        let department_id = '';
        $(document).ready(function(){
            $('#btnSearch').on('click', function() {
                serial = $('#serial').val();
                let branch_id = $('select[name="branch_id"]').val();
                let department_id = $('select[name="department_id"]').val();
                $('#dt-basic-example').DataTable().ajax.reload();
            });
            $('.btn-reset').on('click', function() {
                serial = '';
                branch_id = '';
                department_id = '';
                // Reset input fields
                $('#serial').val('');
                $('select[name="department_id"]').val('').trigger('change');
                $('select[name="branch_id"]').val('').trigger('change');
                $('#serial').val('');
                $('#dt-basic-example').DataTable().ajax.reload();
            });
            dataTables();
            $(".upload_file_data").on("click", function() {
                if ($('#result_file').val() == "") {
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css("color", "red");
                    $(".thanLess").show();
                    return false;
                }
                var file_data = $('#result_file').prop('files')[0];
                var fileName = file_data['name'];
                var form_data = new FormData();
                var fileExtension = fileName.split('.').pop();
                var fileSize = file_data['size'];
                form_data.append('file', file_data);
                form_data.append('_token', "{{ csrf_token() }}");
                if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {

                    $(".upload_file_data").prop('disabled', true);
                    $(".btn-hidden-show").hide();
                    $(".btn-impot-loading").css('display', 'block');

                    $("#modal-import").modal("show");
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/asset/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.mg == 'success') {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/asset') }}");
                            }
                        },error: function(xhr, status, error) {
                            // Display error message if AJAX request fails
                            Swal.fire("Error!", "An error occurred while processing your request. Please try again.","error");
                        },
                    });
                }else{
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css("color", "red");
                    $(".thanLess").show();
                }
            });
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
        function dataTables() {
            $('#dt-basic-example').DataTable({
                // dom: 'Blfrtip',
                pageLength: 10,
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/asset") }}',
                    type: 'GET',
                    data: function(d) {
                        d.serial = serial;
                        d.branch_id = $('select[name="branch_id"]').val();
                        d.department_id = $('select[name="department_id"]').val();
                    }
                },
                columns: [
                    {
                        data: 'serial',
                        name: 'serial',
                        orderable: true
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        orderable: true
                    },
                    {
                        data: 'device_name',
                        name: 'device_name',
                        orderable: true
                    },
                    {
                        data: 'branch_name_kh',
                        name: 'branch_name_kh',
                        orderable: true
                    },
                    {
                        data: 'depart_name',
                        name: 'depart_name',
                        orderable: true
                    },
                    {
                        data: 'location_name',
                        name: 'location_name',
                        orderable: true
                    },
                    {
                        data: 'employee_name_en',
                        name: 'employee_name_en',
                        orderable: true
                    },
                    {
                        data: 'name_english',
                        name: 'name_english',
                        orderable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        render: function (data, type, row) {
                            if (!data) return '';

                            const defaultMonth = 60;
                            const startDate = new Date(data);
                            const currentDate = new Date();

                            // Calculate month difference
                            let months =
                                (currentDate.getFullYear() - startDate.getFullYear()) * 12 +
                                (currentDate.getMonth() - startDate.getMonth());

                            return months >= defaultMonth
                                ? -(months - defaultMonth)
                                : months;
                        },
                        orderable: false
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            let buttons = '';
                            if (row.id) {
                                if (edit) {
                                    buttons += `<a href="{{url('/admin/asset')}}/${row.id}/edit" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>`;
                                }
                                if (assetDelete) {
                                    buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-2 btnDelete" data-toggle="modal" data-target="#delete_asset"  title="Delete Record" data-id="${row.id}"><i class="fal fa-times"></i></a>`;
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
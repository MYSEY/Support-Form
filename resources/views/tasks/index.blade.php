@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-xl-12">
            @if(Auth::user()->can('Task Create') || Auth::user()->can('Task Import'))
                <div class="">
                    <div class="text-lg-right">
                        @can('Task Import')
                            <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1"><i class="fal fa-file"></i> Import</a>
                        @endcan
                        @can('Task Create')
                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#taskCreate" type="button">
                                <span><i class="fal fa-plus mr-1"></i> Add New</span>
                            </button>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Task List
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>TaskName</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>CreatedAt</th>
                                        <th width="80px">Action</th>
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
    <!-- Delete Task Modal -->
    <div class="modal custom-modal fade" id="delete_task" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/task/delete')}}" method="POST">
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
    @include('tasks.import')
    @include('tasks.create')
    @include('tasks.edit')
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script>
        var edit = @json(Auth::user()->can('Task Edit'));
        var Taskdelete = @json(Auth::user()->can('Task Delete'));

        $(function(){
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
                        url: "{{ url('admin/task/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.mg == 'success') {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/task') }}");
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
            $(document).on('click','#btn_updated',function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: `{{ url('/admin/task/${id}') }}`,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            $('#e_id').val(response.success.id);
                            $('#e_name').val(response.success.name);
                            $('#e_type').val(response.success.type);
                            $('#e_description').val(response.success.description);
                            $('#modalTaskEdit').modal('show');
                        }
                    }
                });
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
                // order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/task") }}',
                    type: 'GET'
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            let buttons = '';
                            if (row.id) {
                                if (edit) {
                                    buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" id="btn_updated" data-toggle="modal" data-target="#user-edit" data-id="${row.id}" title="Edit"><i class="fal fa-edit"></i></a>`;
                                }
                                if (Taskdelete) {
                                    buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_task" title="Delete Record" data-id="${row.id}"><i class="fal fa-times"></i></a>`;
                                }
                            }
                            return buttons || '';
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }
    </script>
@endsection
@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-xl-12">
            @if(Auth::user()->can('Category Create') || Auth::user()->can('Task Import'))
                <div class="">
                    <div class="text-lg-right">
                        @can('Task Import')
                            <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1">Import</a>
                        @endcan
                        @can('Category Create')
                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#CategoryCreate" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
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
                        Category 
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>CategoryName</th>
                                        <th>CreatedAt</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('Category Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_task" title="Delete Record" data-id="{{$item->id}}"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        @can('Category Edit')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" id="btn_updated" data-toggle="modal" data-target="#user-edit" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
                                                        @endcan
                                                        @can('Category Edit')
                                                            <a href="{{url('admin/category',$item->id)}}" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" title="Detail"><i class="fal fa-eye"></i></a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_task" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/category/delete')}}" method="POST">
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
    @include('category.import')
    @include('category.create')
    @include('category.edit')
@endsection

@section('script')
@include('includs.datatable_basic')
    <script>
        $(function(){
            $('#createTask').select2({
                dropdownParent: $('#CategoryCreate')
            });
            $('#e_task').select2({
                dropdownParent: $('#CategoryEdit')
            });
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
                        url: "{{ url('admin/category/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.mg == 'success') {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/category') }}");
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
                    url: `{{ url('/admin/category/${id}/edit') }}`,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            $('#e_category_id').val(response.success.id);
                            $('#e_name').val(response.success.name);
                            let taskIds = response.success.category_tasks.map(task => task.task_id);
                            $('.e_task').val(taskIds).trigger('change');
                            $('#CategoryEdit').modal('show');
                        }
                    }
                });
            });
        });
        $(document).on('click','.btnDelete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    </script>
@endsection
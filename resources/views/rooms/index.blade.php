@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Rooms
                    </h2>
                </div>
                <div class="panel-container show">
                    @can('Room Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                @can('Room Import')
                                    <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1">Import</a>
                                @endcan 
                                <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#roomCreate" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
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
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('Task Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_task" title="Delete Record" data-id="{{$item->id}}"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        {{-- @can('Task Edit') --}}
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" id="btn_updated" data-toggle="modal" data-target="#user-edit" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
                                                        {{-- @endcan --}}
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
    <!-- Delete Branch Modal -->
    <div class="modal custom-modal fade" id="delete_task" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/room/delete')}}" method="POST">
                            @csrf
                            @method('Delete')
                            <input type="hidden" name="id" class="e_id" id="e_id" value="">
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
    @include('rooms.import')
    @include('rooms.create')
    @include('rooms.edit')
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script>
        $(function(){
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
                        url: "{{ url('admin/room/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.mg == 'success') {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/room') }}");
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
                    url: `{{ url('/admin/room/${id}') }}`,
                    dataType: "JSON",
                    success: function (response) {                        
                        if (response.success) {
                            $('#e_room_id').val(response.success.id);
                            $('#e_name').val(response.success.name);
                            $('#roomEdit').modal('show');
                        }
                    }
                });
            });
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection
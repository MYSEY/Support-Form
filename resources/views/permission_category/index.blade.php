@extends('layouts.admin')
@section('content')
    <style>
        .rating {
            font-size: 24px;
            color: gold; /* Default color of stars */
            display: inline-block;
        }

        .rating .star {
            cursor: pointer;
            float: left;
            font-size: 24px;
            color: #ccc; /* Default color of inactive stars */
        }

        .rating .star:hover,
        .rating .star.active {
            color: gold; /* Color of active stars */
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Module Access
                    </h2>
                </div>
                
                <div class="panel-container show">
                    @can('Permission Category Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <button class="btn btn-sm btn-success waves-effect waves-themed" data-toggle="modal" data-target="#permission-category-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data)>0)
                                    @foreach ($data as $key=>$item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->created_by}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="d-flex demo">
                                                    @can('Permission Category Delete')
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btn_delete" data-toggle="modal" data-target="#delete_permission_category" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                    @endcan
                                                    @can('Permission Category Edit')
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 btn_updated" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>                                                         
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

    <div class="modal fade" id="permission-category-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Module Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" required>
                        </div>
                        <div class="float-lg-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn_save">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="permission-category-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Module Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" id="e_name" class="form-control @error('name') is-invalid @enderror" name="name" required>
                        </div>
                        <div class="float-lg-right">
                            <input type="hidden" name="id" class="e_cate_id" value="">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn_edit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Permission Category Modal -->
    <div class="modal custom-modal fade" id="delete_permission_category" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/permissions/category/delete')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
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
        $(function(){
            $('.btn_save').on('click',function(){
                duplicate($("#name").val(), function(response){
                    if (response.data == 0) {
                        $.ajax({
                            type: "POST",
                            url: `{{ url('admin/permissions/category') }}`,
                            data:{
                                "_token": "{{ csrf_token() }}",
                                "name": $("#name").val()
                            },
                            dataType: "JSON",
                            success: function (response) {
                                toastr.success('Create successfully.');
                                window.location.replace("{{ URL('admin/permissions/category') }}"); 
                            }
                        })
                    }else{
                        toastr.error(response.message);
                    }
                })
            });

            $('.btn_edit').on('click',function(){
                duplicate($("#e_name").val(), function(response){
                    if (response.data == 0) {
                        $.ajax({
                            type: "PUT",
                            url: `{{ url('admin/permissions/category/update') }}`,
                            data:{
                                "_token": "{{ csrf_token() }}",
                                "id": $(".e_cate_id").val(),
                                "name": $("#e_name").val()
                            },
                            dataType: "JSON",
                            success: function (response) {
                                toastr.success('Updated Permission Category successfully.');
                                window.location.replace("{{ URL('admin/permissions/category') }}"); 
                            }
                        })
                    }else{
                        toastr.error(response.message);
                    }
                })
            });

            $('.btn_updated').on('click',function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: `{{ url('admin/permissions/category/${id}') }}`,
                    dataType: "JSON",
                    success: function (response) {
                        $('.e_cate_id').val(response.success.id)
                        $('#e_name').val(response.success.name)
                        $('#permission-category-edit').modal('show');
                    }
                });
            });
        });
        function duplicate(data, callback){
            $.ajax({
                type: "POST",
                url: `{{ url('admin/permissions/category/duplicate') }}`,
                data:{
                    "_token": "{{ csrf_token() }}",
                    "name": data
                },
                dataType: "JSON",
                success: function (response) {
                    callback(response);
                }
            });
        }

        $(document).on('click','.btn_delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });

    </script>
@endsection
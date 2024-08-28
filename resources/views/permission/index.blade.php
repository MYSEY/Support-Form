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
                        Module Permission
                    </h2>
                </div>
                
                <div class="panel-container show">
                    @can('Permission Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a href="{{url('admin/permission/create')}}" class="btn btn-sm btn-success waves-effect waves-themed"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
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
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="d-flex demo">
                                                    @can('Permission Delete')
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btn_delete" data-toggle="modal" data-target="#delete_permission" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                    @endcan
                                                    @can('Permission Edit')
                                                        <a href="{{url('admin/permission',$item->id)}}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>                                                         
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

    <!-- Delete Permission Category Modal -->
    <div class="modal custom-modal fade" id="delete_permission" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/permission/delete')}}" method="POST" enctype="multipart/form-data">
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
        $(document).on('click','.btn_delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    </script>
@endsection
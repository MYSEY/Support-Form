@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Role Permission
                </h2>
            </div>
            
            <div class="panel-container show">
                @can('Role Create')
                    <div class="panel-tag">
                        <div class="text-lg-right">
                            <a href="{{url('admin/role/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                        </div>
                    </div>
                @endcan
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th>Role Type</th>
                                <th>Guard Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="role_type">{{$item->role_type}}</td>
                                        <td>{{$item->guard_name}}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                @can('Role Delete')
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 role-delete" data-toggle="modal" data-target="#delete_role" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                @endcan
                                                @can('Role Edit')
                                                <a href="{{url('admin/role',$item->id)}}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete role  -->
<div class="modal custom-modal fade" id="delete_role" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/role/delete')}}" method="POST" enctype="multipart/form-data">
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
        $(document).on('click','.role-delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    </script>
@endsection
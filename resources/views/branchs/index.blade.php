@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Branch
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#branch-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                    </div>
                </div>
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name (KH)</th>
                                <th>Name (EN)</th>
                                <th>Location (KH)</th>
                                <th>Location (EN)</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->branch_name_kh}}</td>
                                        <td>{{$item->branch_name_en}}</td>
                                        <td>{{$item->address_kh}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 branch-delete" data-toggle="modal" data-target="#delete_branch" title="Delete Record" data-id="{{$item->id}}"><i class="fal fa-times"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 update" title="Edit" data-id="{{$item->id}}"><i class="fal fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">@lang('lang.no_record_to_display')</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create New Branch -->
<div class="modal fade" id="branch-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/branch/store ')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Name(KH)</label>
                        <input type="text" class="form-control" name="branch_name_kh" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Name(EN)</label>
                        <input type="text" class="form-control" name="branch_name_en" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (KH)</label>
                        <textarea class="form-control" rows="3" name="address_kh" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (EN)</label>
                        <textarea class="form-control" rows="3" name="address" required></textarea>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Branch -->
<div class="modal fade" id="branch-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/branch/update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="e_id" class="e_id" value="">
                    <div class="form-group">
                        <label class="form-label">Name(KH)</label>
                        <input type="text" class="form-control" id="e_branch_name_kh" name="branch_name_kh" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Name(EN)</label>
                        <input type="text" class="form-control" id="e_branch_name_en" name="branch_name_en" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (KH)</label>
                        <textarea class="form-control" rows="3" id="e_address_kh" name="address_kh" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (EN)</label>
                        <textarea class="form-control" rows="3" id="e_address" name="address" required></textarea>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Delete Branch Modal -->
 <div class="modal custom-modal fade" id="delete_branch" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/branch/delete')}}" method="POST">
                        @csrf
                        <input type="hidden"  name="id" class="e_id" value="">
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
            $(document).on('click','.update', function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/branch/edit')}}",
                    data: {
                        id : id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            $('#e_id').val(response.success.id);
                            $('#e_branch_name_kh').val(response.success.branch_name_kh);
                            $('#e_branch_name_en').val(response.success.branch_name_en);
                            $('#e_address').val(response.success.address);
                            $('#e_address_kh').val(response.success.address_kh);
                            $('#branch-edit').modal('show');
                        }
                    }
                });
            });

            $(document).on('click','.branch-delete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection

@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Departments
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <button class="btn btn-sm btn-success waves-effect waves-themed" data-toggle="modal" data-target="#department-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
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
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="ids">{{$item->id }}</td>
                                        <td class="name_khmer">{{$item->name_khmer}}</td>
                                        <td class="name_english">{{$item->name_english}}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 department-delete" data-toggle="modal" data-target="#delete_department" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 update" data-toggle="modal" data-id="{{$item->id}}"  data-target="#department-edit" title="Edit"><i class="fal fa-edit"></i></a>
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
<!-- Modal Create New Department -->
<div class="modal fade" id="department-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/department/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate >
                    @csrf
                    <div class="form-group">
                        <label class="form-label" >Name(KH)</label>
                        <input type="text" id="name_khmer" class="form-control" name="name_khmer" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" >Name(EN)</label>
                        <input type="text" id="name_english" class="form-control" name="name_english" required>
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
<!-- Modal Edit Department -->
<div class="modal fade" id="department-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/department/update')}}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id" class="e_id" value="">
                    <div class="form-group">
                        <label class="form-label">Name(KH)</label>
                        <input type="text" id="e_name_khmer" name="name_khmer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Name(EN)</label>
                        <input type="text" id="e_name_english" name="name_english"class="form-control" required>
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
 <!-- Delete Department Modal -->
 <div class="modal custom-modal fade" id="delete_department" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/department/delete')}}" method="POST">
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
                var _this = $(this).parents('tr');
                let id = $(this).data("id");
                $('.e_id').val(id);
                $('#e_name_khmer').val(_this.find('.name_khmer').text());
                $('#e_name_english').val(_this.find('.name_english').text());
            });

            $(document).on('click','.department-delete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection


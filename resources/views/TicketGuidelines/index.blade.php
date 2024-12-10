@extends('layouts.admin')
@section('content')

@can('Knowledgebase Create')
    <div class="demo">
        <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#ticket-guyline-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
    </div>
@endcan
<div class="panel-content">
    <div class="card-deck justify-content-center">
        <div class="row w-100">
            @foreach ($datas as $index => $item)
                <div class="col-md-4 mb-4 p-0">
                    <div class="card border-success draggable" draggable="true">
                        <div class="card-header border-success">{{$item->title}}</div>
                        <div class="card-body">
                            {!! $item->remark !!}
                           {{$item->attachments ? "* Click to view the guide": ""}} <a href="{{url("storage/attachments")}}/{{$item->attachments}}" target="_blank">{{$item->attachments}}</a>
                        </div>
                        <div class="card-footer text-lg-right">
                            @can('Knowledgebase Delete')
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 guideline-delete" data-toggle="modal" data-target="#delete_" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                            @endcan
                            @can('Knowledgebase Edit')
                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 btn-update" title="Edit" data-id="{{$item->id}}"><i class="fal fa-edit"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Create New ticket Guideline -->
<div class="modal fade" id="ticket-guyline-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Guideline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-guideline" action="{{url('admin/ticket-guideline')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="form-group">
                        <label for="department">Department <span class="text-danger">*</span></label>
                        <select class="form-control" id="department" name="department_id" required>
                            <option value=""> -- Select --</option>
                            @foreach ($department as $item)
                                <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Documents</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachments" id="attachments">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="js-summernote" id="saveToLocal"></div>
                        <input type="hidden" name="remark" id="content">
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="guideline-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Guideline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-guideline_e" action="{{url('admin/ticket-guideline/update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="e_id" value="">
                    <div class="form-group">
                        <label for="e_title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="e_title" required>
                    </div>
                    <div class="form-group">
                        <label for="e_department">Department <span class="text-danger">*</span></label>
                        <select class="form-control" id="e_department" name="department_id" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Documents</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachments" id="e_attachments">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="js-summernote saveToLocal" id="saveToLocal"></div>
                        <input type="hidden" name="remark" id="e_content">
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- Delete Modal -->
 <div class="modal custom-modal fade" id="delete_" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/ticket-guideline/delete')}}" method="POST">
                        @csrf
                        @method('DELETE')
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
    @include('includs.summernote')
    <script>
        $(document).ready(function() {
            $('#form-create-guideline').on('submit', function() {
                var summernoteContent = $('#saveToLocal').summernote('code');
                $('#content').val(summernoteContent);
            });
            $('#form-create-guideline_e').on('submit', function() {
                var summernoteContent = $('.saveToLocal').summernote('code');
                $('#e_content').val(summernoteContent);
            });
        });
        $(document).on('click','.guideline-delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
        $(function(){
            $('.btn-update').on('click',function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/ticket-guideline/edit')}}",
                    data: {
                        id : id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            if (response.department != '') {
                                $('#e_department').html('<option value=""> -- Select --</option>');
                                $.each(response.department, function(i, item) {
                                    $('#e_department').append($('<option>', {
                                        value: item.id,
                                        text: item.name_english,
                                        selected: item.id == response.success.department_id
                                    }));
                                });
                            };
                            $("#e_id").val(response.success.id);
                            $('#e_title').val(response.success.title);
                            $('.saveToLocal').summernote('code', response.success.remark);
                            $('#guideline-edit').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endsection

@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Responses Ticket
                </h2>
            </div>
            
            <div class="panel-container show">
                @can('Responses Ticket Create')
                    <div class="panel-tag">
                        <div class="text-lg-right">
                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#responses-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                        </div>
                    </div>
                @endcan
               
                <div class="panel-content">
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @foreach ($datas as $key=>$item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td class="title">{{$item->title}}</td>
                                        <td >{{ $item->department ? $item->department->name_english : ""}}</td>
                                        <td >{!! $item->message !!}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                @can('Responses Ticket Delete')
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 responsesDelete" data-toggle="modal" data-target="#responses_status" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                @endcan
                                                @can('Responses Ticket Edit')
                                                    <a class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 update" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
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

<!-- Modal Create New responses ticket -->
<div class="modal custom-modal fade" id="responses-create" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new responses ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-responses" action="{{url('admin/ticket-responses')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" required>
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
                        <label for="department">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                        {{-- <div class="js-summernote" id="saveToLocal"></div>
                        <input type="hidden" name="message" id="content"> --}}
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

<!-- Modal Edit responses ticket -->
<div class="modal fade" id="editResponses" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit responses ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-responses_e" action="#" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" class="e_id" id="e_id" value="">
                    <div class="form-group">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" id="e_title" class="form-control @error('title') is-invalid @enderror" name="title">
                    </div>
                    <div class="form-group">
                        <label for="department">Department <span class="text-danger">*</span></label>
                        <select class="form-control" id="e_department_id" name="department_id" required>
                            <option value=""> -- Select --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="e_message" name="message" rows="5"></textarea>
                        {{-- <div class="js-summernote saveToLocal" id="saveToLocal"></div>
                        <input type="hidden" name="message" id="e_content"> --}}
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

<!-- Delete responses ticket Modal -->
<div class="modal custom-modal fade" id="responses_status" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form id="delete-form" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("DELETE")
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-themed ml-2">Delete</button>
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
        $(function(){
            // $(document).ready(function() {
            //     $('#form-create-responses').on('submit', function() {
            //         var summernoteContent = $('#saveToLocal').summernote('code');
            //         $('#content').val(summernoteContent);
            //     });
            //     $('#form-create-responses_e').on('submit', function() {
            //         var summernoteContent = $('.saveToLocal').summernote('code');
            //         $('#e_content').val(summernoteContent);
            //     });
            // });
            $('.update').on('click',function(){
                let id = $(this).data("id");
                let editUrl = `/admin/ticket-responses/${id}/edit`;
                $.ajax({
                    type: "GET",
                    url: editUrl,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            if (response.department != '') {
                                $('#e_department_id').html('<option value=""> -- Select --</option>');
                                $.each(response.department, function(i, item) {
                                    $('#e_department_id').append($('<option>', {
                                        value: item.id,
                                        text: item.name_english,
                                        selected: item.id == response.success.department_id
                                    }));
                                });
                            };
                            $('#e_id').val(response.success.id);
                            $('#e_title').val(response.success.title);
                            $('#e_message').val(response.success.message);
                            $('#editResponses').modal('show');
                            let actionUrl = `/admin/ticket-responses/${response.success.id}`;
                            $('#form-create-responses_e').attr('action', actionUrl);
                        }
                    }
                });
            });

            $(".responsesDelete").on('click',function(){
                let id = $(this).data("id");
                let actionUrl = `/admin/ticket-responses/${id}`;
                $('#delete-form').attr('action', actionUrl);
            });
        });
    </script>
@endsection

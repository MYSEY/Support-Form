@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Issue Type
                </h2>
            </div>
            
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#issue-type-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                    </div>
                </div>
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Issue Type Name</th>
                                <th>Department</th>
                                <th>Required</th>
                                <th>Category Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td>{{$item->department ? $item->department->name_english : ""}}</td>
                                        <td>{{$item->req == 0 ? "No" : "Yes"}}</td>
                                        <td>{{$item->category_type == 0 ? "All" : "Select"}}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 IssueTypeDelete" data-toggle="modal" data-target="#issue_type" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                <a class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 data-show" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
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

<!-- Modal Create New Issue Type -->
<div class="modal custom-modal fade" id="issue-type-create" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Issue Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate>
                {{-- <form action="{{url('admin/issue-type')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate> --}}
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control issue_required @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <div class="demo">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input check-category" data-id="1" id="all" name="issue_category" checked="">
                                        <label class="custom-control-label" for="all">All</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input check-category" data-id="2" id="check-department" name="issue_category">
                                        <label class="custom-control-label" for="check-department">Department</label>
                                    </div>
                                    {{-- <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input check-category" data-id="3" id="check-branch" name="issue_category">
                                        <label class="custom-control-label" for="check-branch">Branch</label>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="form-group department" style="display: none">
                                <label class="form-label" for="department">Department: <span class="text-danger">*</span></label>
                                <select class="form-control" id="department">
                                    <option value=""> -- Select --</option>
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}">{{ $item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Required</label>
                                <div class="frame-wrap">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="issue_no" name="issue_req" checked="">
                                        <label class="custom-control-label" for="issue_no">No</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="issue_yes" name="issue_req">
                                        <label class="custom-control-label" for="issue_yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-save" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Issue Type -->
<div class="modal fade" id="editIssueType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Issue Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form action="{{url('admin/issue-type/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('PUT') --}}
                <form class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id" class="e_id" id="e_id" value="">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control e_issue_required @error('name') is-invalid @enderror" id="e_name" name="name" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <div class="demo">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input e_check-category" data-id="1" id="e_all" name="e_issue_category" checked="">
                                        <label class="custom-control-label" for="e_all">All</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input e_check-category" data-id="2" id="e_check-department" name="e_issue_category">
                                        <label class="custom-control-label" for="e_check-department">Department</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group e_department" style="display: none">
                                <label class="form-label" for="e_department">Department: <span class="text-danger">*</span></label>
                                <select class="form-control" id="e_department">
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Required</label>
                                <div class="frame-wrap">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="e_no" value="0" name="inlineDefaultRadiosExample" checked="">
                                        <label class="custom-control-label" for="e_no">No</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="e_yes" value="1" name="inlineDefaultRadiosExample">
                                        <label class="custom-control-label" for="e_yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-update" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Department Modal -->
<div class="modal custom-modal fade" id="issue_type" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/issue-type/delete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("DELETE")
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
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
        $(function(){
            $(".check-category").on("click", function () {
                $("#department").val("");
                if ($(this).data("id") == 2) {
                    $(".department").css("display", "block");
                }else{
                    $(".department").css("display", "none");
                }
            });
            $(".e_check-category").on("click", function () {
                $("#e_department").val("");
                if ($(this).data("id") == 2) {
                    $(".e_department").css("display", "block");
                }else{
                    $(".e_department").css("display", "none");
                }
            });

            $("#btn-save").on("click", function() {
                var num_miss = 0;
                let category_type = 0;
                $(".issue_required").each(function(){
                    if($(this).val()==""){ 
                        num_miss++;
                        $(this).addClass("is-invalid");
                        $(this).removeClass("is-valid");
                    }else{
                        $(this).addClass("is-valid");
                        $(this).removeClass("is-invalid");
                    }
                });
                if ($("#check-department").prop("checked")) {
                    category_type = 1;
                    if ($("#department").val() == "") {
                        $("#department").addClass("is-invalid");
                        $("#department").removeClass("is-valid");
                        toastr.error("Please check field all required!");
                        return false;
                    }
                }else{
                    category_type = 0;
                    $("#department").val("");
                    $("#branch").val("");
                    $("#branch").removeClass("issue_required");
                    $("#department").removeClass("issue_required");
                };
                if (num_miss>0) {
                    toastr.error("Please check field all required!");
                    return false;
                }else{
                    let req_field = 0;
                    if ($("#issue_yes").prop("checked")) {
                        req_field = 1;
                    }else{
                        req_field = 0;
                    };
                    // console.log("val: ",textarea[0]);
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/issue-type')}}",
                        data: {
                            "_token":                   "{{ csrf_token() }}",
                            name:                       $("#name").val(),
                            // type:                       $("#select-type").val(),
                            req:                        req_field,
                            category_type:              category_type,
                            department_id:              $("#department").val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Create user successfully.');
                                window.location.replace("{{ URL('admin/issue-type') }}"); 
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(error);
                        }
                    });
                }
            });

            $("#btn-update").on("click", function() {
                var num_miss = 0;
                let category_type = 0;
                $(".e_issue_required").each(function(){
                    if($(this).val()==""){ 
                        num_miss++;
                        $(this).addClass("is-invalid");
                        $(this).removeClass("is-valid");
                    }else{
                        $(this).addClass("is-valid");
                        $(this).removeClass("is-invalid");
                    }
                });
                if ($("#e_check-department").prop("checked")) {
                    category_type = 1;
                    if ($("#e_department").val() == "") {
                        $("#e_department").addClass("is-invalid");
                        $("#e_department").removeClass("is-valid");
                        toastr.error("Please check field all required!");
                        return false;
                    }
                }else{
                    category_type = 0;
                    $("#e_department").val("");
                    $("#e_department").removeClass("e_issue_required");
                };
                if (num_miss>0) {
                    toastr.error("Please check field all required!");
                    return false;
                }else{
                    let req_field = 0;
                    if ($("#e_yes").prop("checked")) {
                        req_field = 1;
                    }else{
                        req_field = 0;
                    };
                    $.ajax({
                        type: "PUT",
                        url: "{{url('admin/issue-type/update')}}",
                        data: {
                            "_token":                   "{{ csrf_token() }}",
                            id:                         $("#e_id").val(),
                            name:                       $("#e_name").val(),
                            // type:                       $("#e_select-type").val(),
                            req:                        req_field,
                            category_type:              category_type,
                            department_id:              $("#e_department").val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Create user successfully.');
                                window.location.replace("{{ URL('admin/issue-type') }}"); 
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(error);
                        }
                    });
                }
            });
            $('.data-show').on('click',function(){
                $(".e_department").css("display", "none");
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/issue-type/edit')}}",
                    data: {
                        id : id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success) {
                            $('#e_id').val(response.success.id);
                            $('#e_name').val(response.success.name);
                            if (response.success.req == 0) {
                                $("#e_no").prop("checked", true);
                            }else{
                                $("#e_yes").prop("checked", true);
                            };
                            if (response.success.category_type == 1) {
                                $("#e_check-department").prop("checked", true);
                                $(".e_department").css("display", "block");
                            }else{
                                $("#e_all").prop("checked", true);
                            };
                            if (response.department != '') {
                                $('#e_department').html('<option value=""> -- Select  --</option>');
                                $.each(response.department, function(i, item) {
                                    $('#e_department').append($('<option>', {
                                        value: item.id,
                                        text: item.name_english,
                                        selected: item.id == response.success.department_id
                                    }));
                                });
                            };
                            $('#editIssueType').modal('show');
                        }
                    }
                });
            });
            $(".IssueTypeDelete").on('click',function(){
                $('.e_id').val($(this).data("id"));
            });
        });
    </script>
@endsection

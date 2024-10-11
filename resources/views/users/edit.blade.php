@extends('layouts.admin')
@section('content')
<style>
    .frame-wrap {
        margin-bottom: 1rem !important; 
    }
</style>
<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Update information user
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <form action="{{ url('admin/user/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Profile</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="profile" id="profile">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                        <div class="">
                            <img src="{{asset('storage/users/profile/'.$data->profile)}}" class="profile-image" alt="{{$data->name}}" style="width: 60px;object-fit: cover;">
                            <input type="hidden" name="old_profile" id="old_profile" value="{{$data->profile}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="user">Name <span class="text-danger">*</span></label>
                            <input type="text" id="user" class="form-control @error('user') is-invalid @enderror" name="user" value="{{$data->user}}">
                            @error('user')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Username <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$data->name}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="e_email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$data->email}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="department_id">Department <span class="text-danger">*</span></label>
                            <select class="form-control @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                @foreach($department as $item)
                                    <option value="{{ $item->id }}" {{ $data->department_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name_english }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch <span class="text-danger">*</span></label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                @foreach($branch as $item)
                                    <option value="{{ $item->id }}" {{ $data->branch_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->branch_name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="">Role Permission <span class="text-danger">*</span></label>
                            <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                @foreach($roles as $item)
                                    <option value="{{ $item->id }}" {{ $data->role_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <input type="hidden" name="id" class="" value="{{$data->id}}">
                        <a href="{{url('admin/user')}}" class="btn btn-secondary  waves-effect waves-themed"><span>Back</span></a>
                        <button type="submit" class="btn btn-primary waves-effect waves-themed">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
        $(function(){
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);
            showdatas(id);
        });
        $("#e_auto_assign").on("click", function () {
            if (!$(this).prop("checked")) {
                $(this).prop("checked", false);
                $(this).val(0)
            }
            if ($(this).prop("checked")) {
                $(this).prop("checked", true);
                $(this).val(1)
            }
        });
        $(document).on('click','#btn-update', function(){
            var num_miss = 0;
            $(".e-tab-pane-tab").removeClass("active");
            $(".e-nav-link-tab").removeClass("active");
            $(".e_user_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).addClass("is-invalid");
                    $(this).removeClass("is-valid");
                }else{
                    $(this).addClass("is-valid");
                    $(this).removeClass("is-invalid");
                }
            });
            if (num_miss>0) {
                toastr.error("Please check field all required!");
                $("#e-btn-tab-user").addClass("active");
                $("#e-tab-user").addClass("show active");
                $("#btn-update").text("Next");
                $("#e-btn-back").hide();
                return false;
            }else{
                let tabId =  parseInt($(this).data('dismiss')) + 1;
                $("#e-btn-back").data("dismiss", "" + tabId);
                $("#btn-update").data("dismiss", "" + tabId);
                if (tabId == 2) {
                    $("#e-btn-back").show();
                    $("#e-btn-tab-2").addClass("active");
                    $("#e-tab-profile").addClass("show active");
                }else if (tabId == 3) {
                    $("#e-btn-back").show();
                    $("#e-btn-tab-3").addClass("active");
                    $("#e-tab-time").addClass("show active");
                }else if (tabId == 4) {
                    $("#e-btn-back").show();
                    $("#e-btn-tab-4").addClass("active");
                    $("#e-tab-preferences").addClass("show active");
                }else if (tabId == 5) { 
                    $("#e-btn-tab-5").addClass("active");
                    $("#e-tap-notifications").addClass("show active");
                    $("#btn-update").text("Save changes");
                }else{
                    const afterreply = $('.e_replying_afterreply:checked').val();
                    let autoreload = 0;
                    let secmin = "";
                    if ($("#e_autoreload").prop("checked")) {
                        autoreload = $("#e_reload_time").val();
                        secmin = $("#e_secmin").val();
                    }
                    let autostart = $("#e_autostart").prop("checked") ? 1 : 0;
                    let notify_customer_new = $("#e_notify_customer_new").prop("checked") ? 1 : 0;
                    let notify_customer_reply = $("#e_notify_customer_reply").prop("checked") ? 1 : 0;
                    let show_suggested = $("#e_show_suggested").prop("checked") ? 1 : 0;
                    let notify_new_unassigned = $("#e_notify_new_unassigned").prop("checked") ? 1 : 0;
                    let notify_new_my = $("#e_notify_new_my").prop("checked") ? 1 : 0;
                    let notify_reply_unassigned = $("#e_notify_reply_unassigned").prop("checked") ? 1 : 0;
                    let notify_reply_my = $("#e_notify_reply_my").prop("checked") ? 1 : 0;
                    let notify_overdue_unassigned = $("#e_notify_overdue_unassigned").prop("checked") ? 1 : 0;
                    let notify_overdue_my = $("#e_notify_overdue_my").prop("checked") ? 1 : 0;
                    let notify_assigned = $("#e_notify_assigned").prop("checked") ? 1 : 0;
                    let notify_note = $("#e_notify_note").prop("checked") ? 1 : 0;
                    let notify_pm = $("#e_notify_pm").prop("checked") ? 1 : 0;
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/user/update')}}",
                        data: {
                            "_token":                   "{{ csrf_token() }}",
                            id:                         $(".e_id").val(),
                            user:                       $("#e_user").val(),
                            name:                       $("#e_name").val(),
                            email:                      $("#e_email").val(),
                            signature:                  $("#e_signature").val(),
                            autoassign:                 $("#e_auto_assign").val(),
                            role_id:                    $("#e_role_permission").val(),
                            department_id:              $("#e_department_id").val(),
                            branch_id:                  $("#e_branch_id").val(),
                            afterreply:                 afterreply,
                            autostart:                  autostart,
                            notify_customer_new:        notify_customer_new,
                            notify_customer_reply:      notify_customer_reply,
                            show_suggested:             show_suggested,
                            autoreload:                 autoreload,
                            secmin:                     secmin,
                            notify_new_unassigned:      notify_new_unassigned,
                            notify_new_my:              notify_new_my,
                            notify_reply_unassigned:    notify_reply_unassigned,
                            notify_reply_my:            notify_reply_my,
                            notify_overdue_unassigned:  notify_overdue_unassigned,
                            notify_overdue_my:          notify_overdue_my,
                            notify_assigned:            notify_assigned,
                            notify_note:                notify_note,
                            notify_pm:                  notify_pm,
                            reload_time:                $("#e_reload_time").val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Update user successfully.');
                                window.location.replace("{{ URL('admin/user') }}"); 
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(error);
                        }
                    });
                }
            }
        })
        function showdatas(id) {
            $.ajax({
                type: "GET",
                url: "{{url('admin/user/show')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.data) {
                        $(".e_id").val(response.data.id);
                        $("#e_user").val(response.data.name);
                        $("#e_email").val(response.data.email);
                        $("#e_name").val(response.data.user);
                        $("#e_signature").text(response.data.signature);
                        $("#e_reload_time").val(response.data.autoreload)
                        $("#e_secmin").val(response.data.secmin)
                        if (response.data.autoassign == 1) {
                            $("#e_auto_assign").prop("checked", true);
                        }else{
                            $("#e_auto_assign").prop("checked", false);
                        }
                        $("#e_auto_assign").val(response.data.autoassign);
                        if (response.data.afterreply == 0) {
                            $("#e_replying_afterreply0").prop("checked", true);
                        };
                        if (response.data.afterreply == 1) {
                            $("#e_replying_afterreply1").prop("checked", true);
                        };
                        if (response.data.afterreply == 2){
                            $("#e_replying_afterreply2").prop("checked", true);
                        };
                        if (response.department != '') {
                            $('#e_department_id').html('<option selected value=""> -- Select --</option>');
                            $.each(response.department, function(i, item) {
                                $('#e_department_id').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.data.department_id
                                }));
                            });
                        };
                        if (response.branch != '') {
                            $('#e_branch_id').html('<option selected value=""> -- Select --</option>');
                            $.each(response.branch, function(i, item) {
                                $('#e_branch_id').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response.data.branch_id
                                }));
                            });
                        };
                        if (response.role != '') {
                            $('#e_role_permission').html('<option selected value=""> -- Select --</option>');
                            $.each(response.role, function(i, item) {
                                $('#e_role_permission').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == response.data.role_id
                                }));
                            });
                        };

                        response.data.autostart ==1 ? $("#e_autostart").prop("checked", true) : $("#e_autostart").prop("checked", false);
                        response.data.notify_customer_new ==1 ? $("#e_notify_customer_new").prop("checked", true) : $("#e_notify_customer_new").prop("checked", false);
                        response.data.notify_customer_reply ==1 ? $("#e_notify_customer_reply").prop("checked", true) : $("#e_notify_customer_reply").prop("checked", false);
                        response.data.show_suggested ==1 ? $("#e_show_suggested").prop("checked", true) : $("#e_show_suggested").prop("checked", false);
                        response.data.autoreload  ? $("#e_autoreload").prop("checked", true) : $("#e_autoreload").prop("checked", false);
                        response.data.notify_new_unassigned ==1 ? $("#e_notify_new_unassigned").prop("checked", true) : $("#e_notify_new_unassigned").prop("checked", false);
                        response.data.notify_new_my ==1 ? $("#e_notify_new_my").prop("checked", true) : $("#e_notify_new_my").prop("checked", false);
                        response.data.notify_reply_unassigned ==1 ? $("#e_notify_reply_unassigned").prop("checked", true) : $("#e_notify_reply_unassigned").prop("checked", false);
                        response.data.notify_reply_my ==1 ? $("#e_notify_reply_my").prop("checked", true) : $("#e_notify_reply_my").prop("checked", false);
                        response.data.notify_overdue_unassigned ==1 ? $("#e_notify_overdue_unassigned").prop("checked", true) : $("#e_notify_overdue_unassigned").prop("checked", false);
                        response.data.notify_overdue_my ==1 ? $("#e_notify_overdue_my").prop("checked", true) : $("#e_notify_overdue_my").prop("checked", false);
                        response.data.notify_assigned ==1 ? $("#e_notify_assigned").prop("checked", true) : $("#e_notify_assigned").prop("checked", false);
                        response.data.notify_note ==1 ? $("#e_notify_note").prop("checked", true) : $("#e_notify_note").prop("checked", false);
                        response.data.notify_pm ==1 ? $("#e_notify_pm").prop("checked", true) : $("#e_notify_pm").prop("checked", false);
                    }
                }
            });
        }
    </script>
@endsection

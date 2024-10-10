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
            Add new user
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <form action="{{ url('admin/user/create') }}" method="POST" enctype="multipart/form-data">
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
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="user">Real name <span class="text-danger">*</span></label>
                            <input type="text" id="user" class="form-control @error('user') is-invalid @enderror" name="user" value="{{old('user')}}">
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
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="department_id">Department <span class="text-danger">*</span></label>
                            <select class="form-control @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                <option value="">-- Select --</option>
                                @if (count($department) > 0)
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch <span class="text-danger">*</span></label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                <option value="">-- Select --</option>
                                @if (count($branch) > 0)
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="role_id">Role Permission <span class="text-danger">*</span></label>
                            <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                <option value="">-- Select --</option>
                                @if (count($rolePermissions) > 0)
                                    @foreach ($rolePermissions as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            <p id="passwordError" style="color: red;"></p>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm password <span class="text-danger">*</span></label>
                            <input type="password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
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
        $(document).ready(function(){
            $('#password').on('input', function(){
                var password = $(this).val();
                var passwordError = $('#passwordError');
                
                // Your validation criteria
                var minLength = 8;
                var hasUpperCase = /[A-Z]/.test(password);
                var hasLowerCase = /[a-z]/.test(password);
                var hasNumber = /\d/.test(password);
                var hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
                
                if(password.length < minLength) {
                    passwordError.text('Password must be at least ' + minLength + ' characters long');
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                } else if(!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                    passwordError.text('Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                } else {
                    passwordError.text('');
                    $(this).addClass("is-valid");
                }
            });
        });
        $("#auto_assign").on("click", function () {
            if (!$(this).prop("checked")) {
                $(this).prop("checked", false);
                $(this).val(0)
            }
            if ($(this).prop("checked")) {
                $(this).prop("checked", true);
                $(this).val(1)
            }
        });
        $(document).on('click','#btn-save', function(){
            var num_miss = 0;
            $(".tab-pane-tab").removeClass("active");
            $(".nav-link-tab").removeClass("active");
            $(".user_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).addClass("is-invalid");
                    $(this).removeClass("is-valid");
                }else{
                    $(this).addClass("is-valid");
                    $(this).removeClass("is-invalid");
                }
            });
            if ($("#password").val() != $("#confirm_password").val()) {
                toastr.error("Password and Confirm password is incorrect. Please review!");
                $("#btn-tab-user").addClass("active");
                $("#tab-user").addClass("show active");
                $("#btn-back").hide();
                return false;
            }
            if (num_miss>0) {
                toastr.error("Please check field all required!");
                $("#btn-tab-user").addClass("active");
                $("#tab-user").addClass("show active");
                $("#btn-back").hide();
                return false;
            }else{
                let tabId =  parseInt($(this).data('dismiss')) + 1;
                $("#btn-back").data("dismiss", "" + tabId);
                $("#btn-save").data("dismiss", "" + tabId);
                if (tabId == 2) {
                    $("#btn-back").show();
                    $("#btn-tab-2").addClass("active");
                    $("#tab-profile").addClass("show active");
                }else if (tabId == 3) {
                    $("#btn-back").show();
                    $("#btn-tab-3").addClass("active");
                    $("#tab-time").addClass("show active");
                }else if (tabId == 4) {
                    $("#btn-back").show();
                    $("#btn-tab-4").addClass("active");
                    $("#tab-preferences").addClass("show active");
                }else if (tabId == 5) { 
                    $("#btn-tab-5").addClass("active");
                    $("#tap-notifications").addClass("show active");
                    $("#btn-save").text("Save changes");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/user/duplicate')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            username: $("#user").val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            var duplicate = response;
                            if (duplicate.data == 1) {
                                toastr.error(duplicate.message);
                                return false;
                            }else{
                                const afterreply = $('.replying_afterreply:checked').val();
                                let autoreload = 0;
                                let secmin = "";
                                if ($("#autoreload").prop("checked")) {
                                    autoreload = $("#reload_time").val();
                                    secmin = $("#secmin").val();
                                }
                                let autostart = $("#autostart").prop("checked") ? 1 : 0;
                                let notify_customer_new = $("#notify_customer_new").prop("checked") ? 1 : 0;
                                let notify_customer_reply = $("#notify_customer_reply").prop("checked") ? 1 : 0;
                                let show_suggested = $("#show_suggested").prop("checked") ? 1 : 0;
                                let notify_new_unassigned = $("#notify_new_unassigned").prop("checked") ? 1 : 0;
                                let notify_new_my = $("#notify_new_my").prop("checked") ? 1 : 0;
                                let notify_reply_unassigned = $("#notify_reply_unassigned").prop("checked") ? 1 : 0;
                                let notify_reply_my = $("#notify_reply_my").prop("checked") ? 1 : 0;
                                let notify_overdue_unassigned = $("#notify_overdue_unassigned").prop("checked") ? 1 : 0;
                                let notify_overdue_my = $("#notify_overdue_my").prop("checked") ? 1 : 0;
                                let notify_assigned = $("#notify_assigned").prop("checked") ? 1 : 0;
                                let notify_note = $("#notify_note").prop("checked") ? 1 : 0;
                                let notify_pm = $("#notify_pm").prop("checked") ? 1 : 0;
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('admin/user/create')}}",
                                    data: {
                                        "_token":                   "{{ csrf_token() }}",
                                        user:                       $("#user").val(),
                                        name:                       $("#name").val(),
                                        email:                      $("#email").val(),
                                        password:                   $("#password").val(),
                                        signature:                  $("#signature").val(),
                                        confirm_password:           $("#confirm_password").val(),
                                        autoassign:                 $("#auto_assign").val(),
                                        role_id:                    $("#role_permission").val(),
                                        department_id:              $("#department_id").val(),
                                        branch_id:                  $("#branch_id").val(),
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
                                        reload_time:                $("#reload_time").val(),
                                    },
                                    dataType: "JSON",
                                    success: function (response) {
                                        if (response.status == "error") {
                                            toastr.error(response.message);
                                        }else{
                                            toastr.success('Create user successfully.');
                                            window.location.replace("{{ URL('admin/user') }}"); 
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        toastr.error(error);
                                    }
                                });
                            }
                        }
                    });
                }
            }
        })
    </script>
@endsection

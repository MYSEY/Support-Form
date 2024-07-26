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
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="user">Real name <span class="text-danger">*</span></label>
                            <input type="text" id="user" class="form-control user_required" name="user" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="name">Username <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control user_required" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control user_required" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" class="form-control user_required" name="password" required>
                            <p id="passwordError" style="color: red;"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm password <span class="text-danger">*</span></label>
                            <input type="password" id="confirm_password" class="form-control user_required" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="role_permission">Role Permission <span class="text-danger">*</span></label>
                            <input type="text" id="role_permission" name="role_permission" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="signature">Signature (max 1000 chars)</label>
                            <textarea class="form-control" id="signature" name="signature" rows="6" maxlength="1000"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="frame-wrap demo">
                                <div class="demo">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="auto_assign" name="autoassign" value="0">
                                        <label class="custom-control-label" for="auto_assign">Auto-assign tickets to this user.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="frame-heading">After replying to a ticket</h5>
                        <div class="frame-wrap">
                            <div class="demo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input replying_afterreply" id="afterreply0" name="defaultExampleRadios" value="0" checked="">
                                    <label class="custom-control-label" for="afterreply0">Show the ticket I just replied to</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input replying_afterreply" id="afterreply1" name="defaultExampleRadios" value="1">
                                    <label class="custom-control-label" for="afterreply1">Return to main administration page</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input replying_afterreply" id="afterreply2" name="defaultExampleRadios" value="2">
                                    <label class="custom-control-label" for="afterreply2">Open next ticket that needs my reply</label>
                                </div>
                            </div>
                        </div>

                        <h5 class="frame-heading">Defaults</h5>
                        <div class="frame-wrap">
                            <div class="demo">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="autostart" checked="">
                                    <label class="custom-control-label" for="autostart">Automatically start timer when I open a ticket</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_customer_new" checked="">
                                    <label class="custom-control-label" for="notify_customer_new">Select notify customer option in the new ticket form</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_customer_reply" checked="">
                                    <label class="custom-control-label" for="notify_customer_reply">Select notify customer option in the ticket reply form</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="show_suggested" checked="">
                                    <label class="custom-control-label" for="show_suggested">Show what knowledgebase articles were suggested to customers</label>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox" style="display: flex; -ms-flex-align: center; align-items: center; margin-top: -5px;">
                                <input type="checkbox" class="custom-control-input" id="autoreload">
                                <label class="custom-control-label" for="autoreload" style="font-weight: 1 !important;">Automatically reload page with ticket list every:</label>
                                <div class="form-group" style="width: 45px !important; margin-left: 8px; margin-bottom: 0;">
                                    <input type="text" class="form-control" id="reload_time" name="reload_time" value="30" maxlength="5" onkeyup="this.value=this.value.replace(/[^\d]+/,'')">
                                </div>
                                <div class="form-group ml-1">
                                    <select class="form-control" id="secmin" style="border: 0px solid #E5E5E5 !important;">
                                        <option>seconds</option>
                                        <option>minutes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="frame-heading">The help desk will send an email notification when:</h5>
                        <div class="frame-wrap">
                            <div class="demo">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_new_unassigned" checked="">
                                    <label class="custom-control-label" for="notify_new_unassigned">A new ticket is submitted with owner: Unassigned</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_new_my" checked="">
                                    <label class="custom-control-label" for="notify_new_my">A new ticket is submitted with owner: Assigned to me</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_reply_unassigned" checked="">
                                    <label class="custom-control-label" for="notify_reply_unassigned">Client responds to a ticket with owner: Unassigned</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_reply_my" checked="">
                                    <label class="custom-control-label" for="notify_reply_my">Client responds to a ticket with owner: Assigned to me</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_overdue_unassigned" checked="">
                                    <label class="custom-control-label" for="notify_overdue_unassigned">A ticket is overdue with owner: Unassigned*</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_overdue_my" checked="">
                                    <label class="custom-control-label" for="notify_overdue_my">A ticket is overdue with owner: Assigned to me*</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_assigned" checked="">
                                    <label class="custom-control-label" for="notify_assigned">A ticket is assigned to me</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_note" checked="">
                                    <label class="custom-control-label" for="notify_note">Someone adds a note to a ticket assigned to me</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notify_pm" checked="">
                                    <label class="custom-control-label" for="notify_pm">A private message is sent to me</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{url('admin/user')}}" class="btn btn-secondary  waves-effect waves-themed"><span>Back</span></a>
                    <button type="button" id="btn-save" class="btn btn-primary waves-effect waves-themed">Submit</button>
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
                $("#btn-save").text("Next");
                $("#btn-back").hide();
                return false;
            }
            if (num_miss>0) {
                toastr.error("Please check field all required!");
                $("#btn-tab-user").addClass("active");
                $("#tab-user").addClass("show active");
                $("#btn-save").text("Next");
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

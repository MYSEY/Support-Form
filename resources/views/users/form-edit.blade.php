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
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id" class="e_id" value="">
                        <div class="form-group">
                            <label class="form-label" for="e_user">Real name <span class="text-danger">*</span></label>
                            <input type="text" id="e_user" class="form-control e_user_required" name="user" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="e_name">Username <span class="text-danger">*</span></label>
                            <input type="text" id="e_name" name="name" class="form-control e_user_required" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="e_email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="e_email" name="email" class="form-control e_user_required" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="e_role_permission">Role Permission <span class="text-danger">*</span></label>
                            <select class="form-control e_user_required" name="role_permission" id="e_role_permission" required>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="e_signature">Signature (max 1000 chars)</label>
                            <textarea class="form-control" id="e_signature" name="signature" rows="6" maxlength="1000"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="frame-wrap demo">
                                <div class="demo">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="e_auto_assign" name="autoassign">
                                        <label class="custom-control-label" for="e_auto_assign">Auto-assign tickets to this user.</label>
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
                                    <input type="radio" class="custom-control-input e_replying_afterreply" id="e_replying_afterreply0" name="defaultExampleRadios" value="0" checked="">
                                    <label class="custom-control-label" for="e_replying_afterreply0">Show the ticket I just replied to</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input e_replying_afterreply" id="e_replying_afterreply1" name="defaultExampleRadios" value="1">
                                    <label class="custom-control-label" for="e_replying_afterreply1">Return to main administration page</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input e_replying_afterreply" id="e_replying_afterreply2" name="defaultExampleRadios" value="2">
                                    <label class="custom-control-label" for="e_replying_afterreply2">Open next ticket that needs my reply</label>
                                </div>
                            </div>
                        </div>
                        <h5 class="frame-heading">Defaults</h5>
                        <div class="frame-wrap">
                            <div class="demo">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="e_autostart">
                                    <label class="custom-control-label" for="e_autostart">Automatically start timer when I open a ticket</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="e_notify_customer_new">
                                    <label class="custom-control-label" for="e_notify_customer_new">Select notify customer option in the new ticket form</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="e_notify_customer_reply">
                                    <label class="custom-control-label" for="e_notify_customer_reply">Select notify customer option in the ticket reply form</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="e_show_suggested">
                                    <label class="custom-control-label" for="e_show_suggested">Show what knowledgebase articles were suggested to customers</label>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox" style="display: flex; -ms-flex-align: center; align-items: center; margin-top: -5px;">
                                <input type="checkbox" class="custom-control-input" id="e_autoreload">
                                <label class="custom-control-label" for="e_autoreload" style="font-weight: 1 !important;">Automatically reload page with ticket list every:</label>
                                <div class="form-group" style="width: 45px !important; margin-left: 8px; margin-bottom: 0;">
                                    <input type="text" class="form-control" id="e_reload_time" value="30" maxlength="5" onkeyup="this.value=this.value.replace(/[^\d]+/,'')">
                                </div>
                                <div class="form-group ml-1">
                                    <select class="form-control" id="e_secmin" style="border: 0px solid #E5E5E5 !important;">
                                        <option>seconds</option>
                                        <option>minutes</option>
                                    </select>
                                </div>
                            </div>
                            <h5 class="frame-heading">The help desk will send an email notification when:</h5>
                            <div class="frame-wrap">
                                <div class="demo">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_new_unassigned">
                                        <label class="custom-control-label" for="e_notify_new_unassigned">A new ticket is submitted with owner: Unassigned</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_new_my">
                                        <label class="custom-control-label" for="e_notify_new_my">A new ticket is submitted with owner: Assigned to me</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_reply_unassigned">
                                        <label class="custom-control-label" for="e_notify_reply_unassigned">Client responds to a ticket with owner: Unassigned</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_reply_my">
                                        <label class="custom-control-label" for="e_notify_reply_my">Client responds to a ticket with owner: Assigned to me</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_overdue_unassigned">
                                        <label class="custom-control-label" for="e_notify_overdue_unassigned">A ticket is overdue with owner: Unassigned*</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_overdue_my">
                                        <label class="custom-control-label" for="e_notify_overdue_my">A ticket is overdue with owner: Assigned to me*</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_assigned">
                                        <label class="custom-control-label" for="e_notify_assigned">A ticket is assigned to me</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_note">
                                        <label class="custom-control-label" for="e_notify_note">Someone adds a note to a ticket assigned to me</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="e_notify_pm">
                                        <label class="custom-control-label" for="e_notify_pm">A private message is sent to me</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{url('admin/user')}}" class="btn btn-secondary  waves-effect waves-themed"><span>Back</span></a>
                    <button type="button" id="btn-update" class="btn btn-primary waves-effect waves-themed">Submit</button>
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
                        $("#e_user").val(response.data.user);
                        $("#e_email").val(response.data.email);
                        $("#e_name").val(response.data.name);
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

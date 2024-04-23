@extends('layouts.admin')

@section('content')
    <style>
        .rating {
            font-size: 24px;
            color: gold; /* Default color of stars */
            display: inline-block;
        }

        .rating .star {
            cursor: pointer;
            float: left;
            font-size: 24px;
            color: #ccc; /* Default color of inactive stars */
        }

        .rating .star:hover,
        .rating .star.active {
            color: gold; /* Color of active stars */
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        User List
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-tag">
                        <div class="text-lg-right">
                            <button type="button" class="btn btn-success btn-sm mr-1" id="btn-modal"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                        </div>
                    </div>
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Name</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Branch</th>
                                    <th>Rating</th>
                                    <th>Auto Asign</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data)>0)
                                    @foreach ($data as $key=>$item)
                                        <tr>
                                            <td></td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->user}}</td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td style="text-align:center">
                                                <div class="rating" data-rating="{{$item->rating}}"></div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="frame-wrap demo">
                                                    <div class="demo">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                {{$item->autoassign == "1" ? "checked": ""}}
                                                                value="{{$item->autoassign}}"
                                                            >
                                                            <label class="custom-control-label"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex demo">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 status-delete" data-toggle="modal" data-target="#delete_user" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 show-data-edit" data-toggle="modal" data-target="#user-edit" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('users.modal-create')
    @include('users.modal-edit')

    <!-- Delete User Modal -->
    <div class="modal custom-modal fade" id="delete_user" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/user/delete')}}" method="POST">
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
        document.addEventListener("DOMContentLoaded", function() {
            var ratings = document.querySelectorAll('.rating');
            ratings.forEach(function(rating) {
                var stars = '';
                var ratingValue = parseFloat(rating.getAttribute('data-rating'));
                for (var i = 1; i <= 5; i++) {
                    if (i <= ratingValue) {
                        stars += '<span class="star active">&#9733;</span>';
                    } else if (i - ratingValue < 1) {
                        stars += '<span class="star active">&#9734;</span>';
                    } else {
                        stars += '<span class="star">&#9734;</span>';
                    }
                }
                rating.innerHTML = stars;
            });
        });

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

        $(document).ready(function(){
            $("#btn-modal").click(function(){
                $("#btn-back").hide();
                $("#user-create").modal("show");
                $(".nav-link-tab").removeClass("active");
                $(".tab-pane-tab").removeClass("active");
                $("#btn-tab-user").addClass("active");
                $("#tab-user").addClass("show active");
                $("#btn-save").data("dismiss", "" + 1);
                $("#btn-back").data("dismiss", "" + 1);
            });
        });
        $(document).on("click", ".nav-link-tab", function () { 
            let tabId = $(this).data("dismiss");
            $("#btn-save").data("dismiss", "" + tabId);
            $("#btn-back").data("dismiss", "" + tabId);
            if (tabId == 1) {
                $("#btn-back").hide();
            }else{
                $("#btn-back").show();
            };
            if (tabId == 5) {
                $("#btn-save").text("Save changes");
            }else{
                $("#btn-save").text("Next");
            }
        });
        $(document).on("click", ".e-nav-link-tab", function () { 
            let tabId = $(this).data("dismiss");
            $("#btn-update").data("dismiss", "" + tabId);
            $("#e-btn-back").data("dismiss", "" + tabId);
            if (tabId == 1) {
                $("#e-btn-back").hide();
            }else{
                $("#e-btn-back").show();
            };
            if (tabId == 5) {
                $("#btn-update").text("Save changes");
            }else{
                $("#btn-update").text("Next");
            }
        });
        $("#auto_assign, #e_auto_assign").on("click", function () {
            if (!$(this).prop("checked")) {
                $(this).prop("checked", false);
                $(this).val(0)
            }
            if ($(this).prop("checked")) {
                $(this).prop("checked", true);
                $(this).val(1)
            }
        });
        $(document).on('click','#btn-back', function(){
            let tabId = $(this).data("dismiss");
            let back = parseInt(tabId) - 1;
            $(".tab-pane-tab").removeClass("show active");
            $(".nav-link-tab").removeClass("active");
            if (back == 1) {
                $("#btn-back").hide();
                $("#btn-save").text("Next");
                $("#btn-tab-user").addClass("active");
                $("#tab-user").addClass("show active");
            }else if (back == 2) {
                $("#btn-save").text("Next");
                $("#btn-back").show();
                $("#btn-tab-2").addClass("active");
                $("#tab-profile").addClass("show active");
            }else if (back == 3) {
                $("#btn-save").text("Next");
                $("#btn-back").show();
                $("#btn-tab-3").addClass("active");
                $("#tab-time").addClass("show active");
            }else if (back == 4) {
                $("#btn-save").text("Next");
                $("#btn-back").show();
                $("#btn-tab-4").addClass("active");
                $("#tab-preferences").addClass("show active");
            }else if(back == 5){
                $("#btn-back").show();
                $("#btn-tab-5").addClass("active");
                $("#tap-notifications").addClass("show active");
            }
            $("#btn-save").data("dismiss", "" + back);
            $("#btn-back").data("dismiss", "" + back);
        });
        $(document).on('click','#e-btn-back', function(){
            let tabId = $(this).data("dismiss");
            let back = parseInt(tabId) - 1;
            $(".e-tab-pane-tab").removeClass("show active");
            $(".e-nav-link-tab").removeClass("active");
            if (back == 1) {
                $("#e-btn-back").hide();
                $("#btn-update").text("Next");
                $("#e-btn-tab-user").addClass("active");
                $("#e-tab-user").addClass("show active");
            }else if (back == 2) {
                $("#btn-update").text("Next");
                $("#e-btn-back").show();
                $("#e-btn-tab-2").addClass("active");
                $("#e-tab-profile").addClass("show active");
            }else if (back == 3) {
                $("#btn-update").text("Next");
                $("#e-btn-back").show();
                $("#e-btn-tab-3").addClass("active");
                $("#e-tab-time").addClass("show active");
            }else if (back == 4) {
                $("#btn-update").text("Next");
                $("#e-btn-back").show();
                $("#e-btn-tab-4").addClass("active");
                $("#e-tab-preferences").addClass("show active");
            }else if(back == 5){
                $("#e-btn-back").show();
                $("#e-btn-tab-5").addClass("active");
                $("#e-tap-notifications").addClass("show active");
            }
            $("#btn-update").data("dismiss", "" + back);
            $("#e-btn-back").data("dismiss", "" + back);
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
        })
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
        $(".show-data-edit").on("click", function () {
        // $(document).on('click','.show', function(){
            let id = $(this).data("id");
            $("#e-btn-back").hide();
            $(".e-nav-link-tab").removeClass("active");
            $(".e-tab-pane-tab").removeClass("active");
            $("#e-btn-tab-user").addClass("active");
            $("#e-tab-user").addClass("show active");
            $("#btn-update").data("dismiss", "" + 1);
            $("#e-btn-back").data("dismiss", "" + 1);
            $("#btn-update").text("Next");
            showdatas(id);
        })
        $(document).on('click','.status-delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
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
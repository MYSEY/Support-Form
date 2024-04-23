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
                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#user-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
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
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 show" data-toggle="modal" data-id="{{$item->id}}" data-target="#user-edit" title="Edit"><i class="fal fa-edit"></i></a>
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
                } else if(!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
                    passwordError.text('Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                } else {
                    passwordError.text('');
                }
            });
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
        $(document).on('click','#btn-save', function(){
            var num_miss = 0;
            $(".user_required").each(function(){
                if($(this).val()==""){ num_miss++;}
            });
            if ($("#password").val() != $("#confirm_password").val()) {
                toastr.error("Password and Confirm password is incorrect. Please review!");
                return false;
            }
            if (num_miss>0) {
                toastr.error("Please check field all required!");
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/user/create')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        user: $("#user").val(),
                        name: $("#name").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                        signature: $("#signature").val(),
                        confirm_password: $("#confirm_password").val(),
                        autoassign: $("#auto_assign").val(),
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
        })
        $(document).on('click','#btn-update', function(){
            var num_miss = 0;
            $(".e_user_required").each(function(){
                if($(this).val()==""){ num_miss++;}
            });
            if (num_miss>0) {
                toastr.error("Please check field all required!");
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/user/update')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: $(".e_id").val(),
                        user: $("#e_user").val(),
                        name: $("#e_name").val(),
                        email: $("#e_email").val(),
                        signature: $("#e_signature").val(),
                        autoassign: $("#e_auto_assign").val(),
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
        })
        $(document).on('click','.show', function(){
            let id = $(this).data("id");
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
                    console.log(response.data);
                    if (response.data) {
                        $(".e_id").val(response.data.id);
                        $("#e_user").val(response.data.user);
                        $("#e_email").val(response.data.email);
                        $("#e_name").val(response.data.name);
                        $("#e_signature").text(response.data.signature);
                        if (response.data.autoassign == 1) {
                            $("#e_auto_assign").prop("checked", true);
                        }else{
                            $("#e_auto_assign").prop("checked", false);
                        }
                        $("#e_auto_assign").val(response.data.autoassign);
                    }
                }
            });
        }
    </script>
@endsection
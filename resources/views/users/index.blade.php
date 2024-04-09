@extends('layouts.admin')

@section('content')
    <style>
        .step-bar {
            margin: 37px 0 0 0;
            padding: 0;
            width: 488px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            border-top: 2px solid #dfe4ec;
        }
        .step-bar li:first-child {
            -ms-flex-align: start;
            align-items: flex-start;
            width: 13%;
            text-align: left;
        }
        .step-bar li {
            width: 20%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-align: center;
            align-items: center;
            font-family: "Lato", Arial, sans-serif;
            font-size: 12px !important;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            line-height: 1.5;
            letter-spacing: 0.1px;
            text-align: center;
            color: #6b7480;
            position: relative;
            /* cursor: pointer; */
        }
        .step-bar .active:nth-child(1)::before {
            border-color: #38bc7d;
            background-color: #38bc7d !important;
        }
        /* .step-bar .active {
            background-color: #007bff;
        } */
        .step-bar li::before {
            content: attr(data-step);
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            width: 24px;
            height: 24px;
            background-color: #959eb0;
            border: 4px solid #dfe4ec;
            border-radius: 50%;
            font-family: "Lato", Arial, sans-serif;
            font-size: 8px;
            font-weight: 600;
            font-style: normal;
            font-stretch: normal;
            line-height: normal;
            letter-spacing: 0.1px;
            text-align: center;
            color: #fff;
            margin-bottom: 8px;
            margin-top: -13px;
        }
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
                                                            <input type="checkbox" class="custom-control-input" id="auto_assign" name="autoassign"
                                                                {{$item->autoassign == "1" ? "checked": ""}}
                                                                value="{{$item->autoassign}}"
                                                            >
                                                            <label class="custom-control-label" for="auto_assign"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex demo">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 status-delete" data-toggle="modal" data-target="#delete_user" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 update" data-toggle="modal" data-id="{{$item->id}}" data-color="{{$item->color}}" data-target="#user-create" title="Edit"><i class="fal fa-edit"></i></a>
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
    <div class="modal fade" id="user-create" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-right"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Add new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="panel-6" >
                        <div class="panel-container show">
                            <div class="panel-content">
                                <ul class="nav step-bar" role="tablist">
                                    <li class="nav-item active" data-step="1" ><a class="active" data-toggle="tab" href="#tab-home" role="tab" aria-selected="true">Profile information</a></li>
                                    <li class="nav-item" data-step="2"><a data-toggle="tab" href="#tab-profile" role="tab" aria-selected="false">Permissions</a></li>
                                    <li class="nav-item" data-step="3"><a data-toggle="tab" href="#tab-time" role="tab">Signature</a></li>
                                    <li class="nav-item" data-step="4"><a data-toggle="tab" href="#tab-time1" role="tab">Preferences</a></li>
                                    <li class="nav-item" data-step="5"><a data-toggle="tab" href="#tab-time2" role="tab">Notifications</a></li>
                                </ul>
                                <div class="tab-content py-3">
                                    <div class="tab-pane fade active show" id="tab-home" role="tabpanel" aria-labelledby="tab-home">
                                        <form class="needs-validation" novalidate>
                                            <div class="form-group">
                                                <label class="form-label" for="user">Real name</label>
                                                <input type="text" id="user" class="form-control user_required" name="user" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control user_required" placeholder="Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="name">Username</label>
                                                <input type="text" id="name" name="name" class="form-control user_required" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" id="password" class="form-control user_required" name="password" required>
                                                <p id="passwordError" style="color: red;"></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="confirm_password">Confirm password</label>
                                                <input type="password" id="confirm_password" class="form-control user_required" name="confirm_password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="frame-wrap demo">
                                                    <div class="demo">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="auto_assign" name="autoassign">
                                                            <label class="custom-control-label" for="auto_assign">Auto-assign tickets to this user.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="btn-save" class="btn btn-primary ml-auto waves-effect waves-themed">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="tab-profile">Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic. </div>
                                    <div class="tab-pane fade" id="tab-time" role="tabpanel" aria-labelledby="tab-time">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        confirm_password: $("#confirm_password").val(),
                        autoassign: $("#auto_assign").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == "error") {
                            toastr.error(response.message);
                        }else{
                            toastr.success('Create user successfully.');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(error);
                    }
                });
            }
        })
        $(document).on('click','.status-delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    </script>
@endsection
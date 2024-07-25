<html lang="en"><head>
    <meta charset="utf-8">
    <title>
        Support Form
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="{{asset('admins/css/page-login.css')}}">
     <!-- base css -->
     <link rel="stylesheet" media="screen, print" href="{{asset('/admins/css/vendors.bundle.css')}}">
     <link rel="stylesheet" media="screen, print" href="{{asset('/admins/css/app.bundle.css')}}">
     <!-- Place favicon.ico in the root directory -->
     <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/admins/img/favicon.ico')}}">
     <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/admins/img/favicon.ico') }}">
     <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
     <!-- Optional: page related CSS-->
     <link rel="stylesheet" media="screen, print" href="{{asset('/admins/css/fa-brands.css') }}">

     {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}
     <link rel="stylesheet" href="{{asset('admins/css/notifications/toastr/toastr.css')}}">
</head>
<body class="desktop chrome webkit pace-done blur"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
<div class="pace-progress-inner"></div>
</div>
<div class="pace-activity">
    </div></div>
    <div class="blankpage-form-field"  id="form-login">
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <img src="{{asset('admins/img/favicon/commalogo1.png')}}" alt="Support Form" aria-roledescription="logo" style="width: 85px !important">
                <span class="page-logo-text mr-1">Welcome! Please login.</span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="username">
                    <span class="help-block">
                        Your unique username to app
                    </span>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="password">
                    <span class="help-block">
                        Your password
                    </span>
                </div>
                <button type="button" onclick="submitForm()" class="btn btn-danger float-right waves-effect waves-themed submit">Secure login</button>
            </form>
        </div>
    </div>

    <div class="modal custom-modal fade" id="modal-change-password" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Please change password!
                    </h3>
                </div>
                <form  id="btn-change-pass" method="POST" action="{{ url('login/change/password') }}">
                    @csrf
                    <div class="modal-body">
                        <input id="cha_username" type="text" name="username" hidden>
                        <div class="form-group">
                            <label class="form-label" for="new_password">New password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password">
                            <p id="passwordError" style="color: red;"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-back">Back</button>
                        <button type="submit" class="btn btn-danger float-right waves-effect waves-themed submit">Click change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <video poster="{{asset('admins/img/backgrounds/clouds.png')}}" id="bgvid" playsinline="" autoplay="" muted="" loop="">
        <source src="{{asset('admins/media/video/cc.webm')}}" type="video/webm">
        <source src="{{asset('admins/media/video/cc.mp4')}}" type="video/mp4">
    </video>
    <script src="{{asset('admins/js/vendors.bundle.js')}}"></script>
    <script src="{{asset('admins/js/app.bundle.js')}}"></script>
    {{-- <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> --}}
    <script src="{{asset('admins/js/notifications/toastr/toastr.js')}}"></script>
    {!! Toastr::message() !!}
    <script>
        document.getElementById("password").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                submitForm();
            }
        });
        document.getElementById("username").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                submitForm();
            }
        });

        $(document).ready(function(){
            $('#new_password').on('input', function(){
                var password = $(this).val();
                var passwordError = $('#passwordError');
                
                // Your validation criteria
                var minLength = 8;
                var hasUpperCase = /[A-Z]/.test(password);
                var hasLowerCase = /[a-z]/.test(password);
                var hasNumber = /\d/.test(password);
                var hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
                
                if(password.length < minLength) {
                    passwordError.text('New password must be at least ' + minLength + ' characters long');
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                } else if(!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                    passwordError.text('New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                } else {
                    passwordError.text('');
                    $(this).addClass("is-valid");
                }
            });
        });

        $(function(){
            $("#btn-back").on("click", function(){
                window.location.replace("{{ URL('login') }}"); 
            });

            $(document).ready(function() {
                $('#btn-change-pass').submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: formData,
                        dataType: "JSON",
                        success: function(response) {
                            let data =  response;
                            console.log("response: ",response);
                            if (data.status == "error") {
                                toastr.error(data.message);
                                return false;
                            }
                            var errors = response.errors;
                            if (errors) {
                                $.each(errors, function(field, messages) {
                                    if (field === 'new_password') {
                                        toastr.error(messages[0]);
                                    } else {
                                        $.each(messages, function(index, message) {
                                            toastr.error(messages);
                                        });
                                    }
                                });
                                return false;
                            }
                            if (data.status == "success") {
                                toastr.success('Login successfully.');
                                window.location.replace("{{ URL('admin/dashboad') }}"); 
                            }
                        },
                    });
                });
            });
        });
        function submitForm() {
            $("#cha_username").val($("#username").val());
            $.ajax({
                type: "post",
                url: "{{ url('/login') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    username: $("#username").val(),
                    password: $("#password").val(),
                },
                dataType: "JSON",
                success: function(response) {
                    let data =  response;
                    if (data.status == "change_password") {
                        $("#form-login").css("display", "none");
                        $("#modal-change-password").modal("show");
                        return false;
                    };
                    if (data.status == "success") {
                        toastr.success(data.message,'Success');
                        window.location.replace("{{ URL('admin/dashboad') }}"); 
                    }else{
                        toastr.error(data.message, 'Error');
                        return false;
                    }
                }
            });
        }
    </script>


</body></html>
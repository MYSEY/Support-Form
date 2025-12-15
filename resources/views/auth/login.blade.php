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
     <style>
        /* -------------------------------------- */
        /* Custom Styling for Login Card (image_646d9d.png) */
        /* -------------------------------------- */

        /* The main container for the form */
        #form-login-card {
            max-width: 380px; /* Set a fixed width like in the image */
            border-radius: 10px; /* Rounded corners for the whole form */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.7); /* Subtle dark shadow */
            overflow: hidden; /* Important to keep children within rounded corners */
            /* You might need to center this container if it's not already centered */
            margin: 20px auto; 
        }

        /* Green Header Bar */
        .login-header {
            background-color: #4aaa48; /* Bright Green */
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* Form Body (The dark area) */
        .card-body {
            padding-top: 40px !important;
            padding-bottom: 20px !important;
        }

        /* Input Fields */
        .form-label {
            /* Make labels white/light gray to stand out on dark background */
            color: #ddd; 
            font-weight: normal;
            margin-bottom: 5px;
        }

        .login-input {
            /* background-color: #1a1a1a; */
            border: 1px solid #7c7c7c; /* Light gray border */
            padding: 10px 15px;
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.6);
        }
        .login-input::placeholder {
            color: #888;
        }

        /* Red Login Button */
        .login-btn-red {
            background-color: #db3a34 !important; /* The Red color from your logo/image */
            border-color: #db3a34 !important;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 8px 30px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .login-btn-red:hover {
            background-color: #c72c27 !important;
            border-color: #c72c27 !important;
        }
        
        /* Hide the help-block if it's still present in the HTML but you don't want it */
        .help-block {
            display: none;
        }

        /* Ensure form-group padding is clean */
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="desktop chrome webkit pace-done blur"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
<div class="pace-progress-inner"></div>
</div>
<div class="pace-activity">
    </div></div>
    <div class="blankpage-form-field"  id="form-login">
        <div class="m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4" style="text-align: center">
            {{-- <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center"> --}}
                <img src="{{asset('admins/img/favicon/commalogo1.png')}}" alt="Support Form" aria-roledescription="logo" style="width: 85% !important">
                {{-- <span class="page-logo-text mr-1">Welcome! Please login.</span>
            </a> --}}
        </div>
        <div class="card-container" id="form-login-card">
            <div class="login-header">
               SYSTEM SUPPORT FORM
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="username"></label>
                        <input type="text" name="username" class="form-control login-input" id="username" placeholder="Username">
                        </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label" for="password"></label>
                        <input type="password" name="password" class="form-control login-input" id="password" placeholder="Password">
                    </div>
                    
                    <div class="d-flex justify-content-center pt-2">
                        <button type="button" onclick="submitForm()" class="btn login-btn-red waves-effect waves-themed submit">
                            LOGIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" role="dialog" data-backdrop="static" id="modal-change-password">
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
    <video poster="{{asset('admins/img/backgrounds/final_background_sf1.jpg')}}" id="bgvid" playsinline="" autoplay="" muted="" loop="">
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
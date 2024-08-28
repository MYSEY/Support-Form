
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Camma Microfinance Limited">
        <meta name="keywords" content="admins, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>HRMS Admin</title>

        <link rel="stylesheet" media="screen, print" href="{{asset('admins/css/vendors.bundle.css')}}">
        <link rel="stylesheet" media="screen, print" href="{{asset('admins/css/app.bundle.css')}}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/admins/img/favicon.ico')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/admins/img/favicon.ico')}}">
        <link rel="mask-icon" href="{{asset('admins/img/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
        {{-- message toastr --}}
        <style>
            body {
                /* background: url({{asset('/admins/img/Error-404-Page-Not-Found.png')}}); */
                background-size: cover;
                font-family: Montserrat;
            }
            .login_box {
                /* width: 60vh; */
                height: auto;
                position: absolute;
                top: 45%;
                left: 50%;
                transform: translate(-50%,-50%);
                background: #fff;
                border-radius: 10px;
                display: flex;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="login_box">
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <img src="{{ asset('/admins/img/Error-404-Page-Not-Found.png') }}" />
                        <button type="button" id="go-back" class="btn btn-danger">Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('admins/js/vendors.bundle.js')}}"></script>
        <script>
            $(function(){
                $("#go-back").on("click", function() {
                    window.location.replace("{{ URL('admin/dashboad') }}");
                });
            });
        </script>
    </body>
</html>
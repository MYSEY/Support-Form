@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="blankpage-form-field"  id="form-login">
            <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                    <img src="{{asset('admins/img/favicon/commalogo1.png')}}" alt="Support Form" aria-roledescription="logo" style="width: 85px !important">
                    <span class="page-logo-text mr-1">Reset Password</span>
                </a>
            </div>
            <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
                <form >
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <select class="select2 form-control w-100 select2-hidden-accessible" name="username" id="username">
                            <option value="" selected> </option>
                            @foreach ($users as $user)
                                <option value="{{$user->user}}">{{ $user->user}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            Your unique username to app
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="new_password">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" id="new_password">
                        <span class="help-block">
                            Your password
                        </span>
                        <p id="passwordError" style="color: red;"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                        <span class="help-block">
                            Your confirm password
                        </span>
                        <p id="comfirmPasswordError" style="color: red;"></p>
                    </div>
                    <button type="button" onclick="submitForm()" class="btn btn-danger float-right waves-effect waves-themed submit">Change Password</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
        document.getElementById("username").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                submitForm();
            }
        });
        document.getElementById("new_password").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                submitForm();
            }
        });

        document.getElementById("confirm_password").addEventListener("keyup", function(event) {
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
        $(document).ready(function(){
            $('#confirm_password').on('input', function(){
                var password = $(this).val();
                var passwordError = $('#comfirmPasswordError');
                
                // Your validation criteria
                var minLength = 8;
                var hasUpperCase = /[A-Z]/.test(password);
                var hasLowerCase = /[a-z]/.test(password);
                var hasNumber = /\d/.test(password);
                var hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
                
                if(password.length < minLength) {
                    passwordError.text('Comfirm password must be at least ' + minLength + ' characters long');
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                } else if(!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                    passwordError.text('Comfirm password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                } else {
                    passwordError.text('');
                    $(this).addClass("is-valid");
                }
            });
        });
        $(function(){
            
        });
        function submitForm() {
            $.ajax({
                type: "post",
                url: "{{ url('admin/reset/password') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    username: $("#username").val(),
                    new_password: $("#new_password").val(),
                    confirm_password: $("#confirm_password").val(),
                },
                dataType: "JSON",
                success: function(response) {
                    let data =  response;
                    if (data.status == "error") {
                        toastr.error(data.message);
                    };
                    if (data.status == "success") {
                        toastr.success(data.message);
                        window.location.replace("{{ URL('admin/reset/password') }}"); 
                    };
                }
            });
        }
    </script>
@endsection

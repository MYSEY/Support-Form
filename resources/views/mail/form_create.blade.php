@extends('layouts.master')
@section('content')
    <form action="#" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="card">
            <div class="card-body">
                <h6 class="card-title fw-semibold mb-2">New Email</h6>
                <p class="card-subtitle mb-3 text-muted">Required fields are marked with <span class="text-danger">*</span>
                </p>

                <div class="input-block mb-3 row">
                    <label class="col-form-label col-md-2">Email:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="email">
                    </div>
                </div>
                <div class="input-block mb-3 row">
                    <label class="col-form-label col-md-2">Subject: <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control email_required" id="subject" required>
                    </div>
                </div>

                <div class="input-block mb-3 row">
                    <label class="col-form-label col-md-2">Message: <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea rows="5" cols="5" class="form-control email_required" id="message" placeholder="Enter text here" required></textarea>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" id="btn-save">Submit</button>
                <a href="{{ url('email') }}" class="btn btn-secondary m-1">Cancel</a>
            </div>
        </div>
    </form>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        var url = window.location.pathname;
        var name_id = url.split("/")[3];
        var department_id = name_id.split("department")[1];
        var branch_id = name_id.split("branch")[1];
        $("#btn-save").on("click", function() {
            var num_miss = 0;
            $("#email").addClass("is-valid");
            $(".email_required").each(function() {
                if ($(this).val() == "") {
                    num_miss++;
                    $(this).addClass("is-invalid");
                    $(this).removeClass("is-valid");
                }else{
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                }
            });
            if (num_miss > 0) {
                new Noty({
                        title: "",
                        text: "Please check input required",
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('email/store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        department_id:department_id,
                        branch_id:branch_id,
                        "email": $("#email").val(),
                        "subject": $("#subject").val(),
                        "message": $("#message").val(),
                    },
                    dataType: "JSON",
                    success: function(response) {
                        new Noty({
                            title: "",
                            text: '@lang('lang.leave_request_created_successfully')',
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('email') }}");
                    }
                });
            }

        });
    });
</script>

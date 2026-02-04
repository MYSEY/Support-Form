@extends('layouts.admin')
@section('content')
<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Insert a new ticket <span class="fw-300"><i>inputs</i></span>
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            {{-- <div class="panel-tag">
                Required fields are marked with <span class="text-danger">*</span>
            </div> --}}
            <form id="form-save-ticket">
                <div class="row">
                    <div class="col-xl-6">
                        {{-- <div class="form-group">
                            <label class="form-label" for="ticket-name">Name: <span class="text-danger">*</span></label>
                            <input type="text" id="ticket-name" class="form-control required" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-email">Email: <span class="text-danger">*</span></label>
                            <input type="email" id="ticket-email" name="example-email-2" class="form-control required" placeholder="Email" required>
                        </div> --}}
                        <div class="form-group">
                            <label class="form-label" for="ticket-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="ticket-subject" class="form-control required" id="ticket-subject" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Description">Description: <span class="text-danger">*</span></label>
                            <textarea class="form-control required" id="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group form-group-select2">
                            <label class="form-label">Issue Type: <span class="text-danger">*</span></label>
                            <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="issue-type" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-subject">Ticket Type: <span class="text-danger">*</span></label>
                            <select class="form-control required" id="ticket_type" name="ticket_type" required>
                                <option value="">  </option>
                                <option value="0"> Normal </option>
                                <option value="1"> Specail Case </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ticket templates (<a type="button" href="#" >Manage ticket templates</a>)</label>
                            <div class="demo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input ticket-templates" value="0" id="ticket-bottom" name="defaultExampleRadios" checked="">
                                    <label class="custom-control-label" for="ticket-bottom">Add to the bottom</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input ticket-templates" value="1" id="ticket-replace-message" name="defaultExampleRadios">
                                    <label class="custom-control-label" for="ticket-replace-message">Replace message</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="form-group form-group-select2">
                            <label class="form-label" for="ticket-priority">Priority: <span class="text-danger">*</span></label>
                            <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="ticket-priority" required>
                                <option value=""></option>
                                @foreach ($priority as $item)
                                    <option value="{{$item->id}}">{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-assign">Assign this ticket to:</label>
                            <select class="select2 form-control w-100 select2-hidden-accessible" id="ticket-assign">
                                <option value="unassigned" selected> > Unassigned < </option>
                                @foreach ($user_support as $user)
                                    <option value="{{$user->id}}">{{ $user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-muted" for="ticket-due-date">Due date:</label>
                            <input class="form-control" id="ticket-due-date" type="date" name="date">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attachments:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="ticket-file">
                                <label class="custom-file-label" for="ticket-file">Choose file</label>
                            </div>
                            <span id="thanLess"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Options:</label>
                            <div class="demo">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="ticket-notification" value="1" name="ticket-notification" checked="">
                                    <label class="custom-control-label" for="ticket-notification">Send email notification to the customer</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="ticket-check-submiss" value="1" name="ticket-check-submiss" checked="">
                                    <label class="custom-control-label" for="ticket-check-submiss">Show the ticket after submissio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-md-right">
                    <div class="btn-hidden-show">
                        <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                        <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn-save" type="button">Submit</button>
                    </div>
                    <input type="hidden" value="{{csrf_token()}}" id="token"/>
                    <div class="btn-loading mt-3" style="display: none">
                        <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
        $(function(){
            var url = window.location.href;
            var parts = url.split('/');
            var namURL = parts.pop() || parts.pop();
            // var department_id = namURL.split("department")[1];
            // var branch_id = namURL.split("branch")[1];
            let datas = {
                branch_id: "",
                department_id: namURL
            };
            $("#ticket-file").on("change", function () {
                let file = this.files[0];
                if (!file) return;

                let fileSize = file.size / 1024; // KB
                if (fileSize > 5120) {
                    $("#thanLess")
                        .text("File size must be less than or equal to 5MB")
                        .css("color", "red");

                    // 🔥 Clear file input (works in all browsers)
                    $(this).replaceWith($(this).val('').clone(true));
                    $(".custom-file-label").text("Choose file");
                    return false;
                }

                $("#thanLess").text("");
            });


            dataIssue(datas);
            $("#btn-save").on("click", function(e) {
                e.preventDefault();
                var formData = new FormData();
                var token = $("#token").val();
                let subject = $("input[name=ticket-subject]").val();
                var priority = $("#ticket-priority").val();
                var assign_to = $("#ticket-assign").val();
                var due_date = $("#ticket-due-date").val();
                var issue_type = $("#issue-type").val();
                var ticket_type = $("#ticket_type").val();
                var overdue_email_sent = $('input[name="ticket-notification"]:checked').val();
                var satisfaction_email_sent = $('input[name="ticket-check-submiss"]:checked').val();
                var description = $("#description").val();
                var attachments = $('#ticket-file').prop('files')[0];
                // var fileSize = attachments ? attachments['size'] : "";
                var fileSize = attachments ? (attachments['size'] / 1024) : "";

                formData.append('_token', token);
                formData.append('department_id', datas.department_id);
                formData.append('branch_id', datas.branch_id);
                formData.append('attachments', attachments);
                formData.append('subject', subject);
                formData.append('priority', priority);
                formData.append('owner', assign_to);
                formData.append('assignedby', assign_to);
                formData.append('due_date', due_date);
                formData.append('issue_type', issue_type);
                formData.append('ticket_type', ticket_type);
                formData.append('overdue_email_sent', overdue_email_sent);
                formData.append('satisfaction_email_sent', satisfaction_email_sent);
                formData.append('message', description);
                if (fileSize <= 5120) {   // ** 5 MB in KB **/
                    $(".btn-hidden-show").hide();
                    $(".btn-loading").css('display', 'block');
                    var num_miss = 0;
                    $(".form-group-select2").each(function(){
                        let formGroup = $(this);
                        let value = formGroup.attr("data-select2-id");
                        let requeredField = formGroup.find(".select2-option").val();
                        let requered = formGroup.find(".required").val();
                        if(!value && requered == ""){ 
                            formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                        }else if(!requeredField && requered == "") {
                            formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                        }else{
                            formGroup.find(".select2-selection--single").css("border-color","#1dc9b7");
                        }
                    });

                    $(".required").each(function(){
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
                        $(".btn-hidden-show").show();
                        $(".btn-loading").css('display', 'none');
                        return false;
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/ticket/save') }}",
                            contentType: 'multipart/form-data',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            dataType: "JSON",
                            success: function(response) {
                                if (response.status == "error") {
                                    toastr.error(response.message);
                                }else{
                                    toastr.success('Create ticket successfully.');
                                    window.location.replace("{{ URL('admin/ticket') }}"); 
                                }
                            }
                        })
                    }
                }else{
                    $(".btn-hidden-show").show();
                    $(".btn-loading").css('display', 'none');
                    $("#thanLess").text("Please check file size less than or equal to 5MB").css("color", "red");
                    return false;
                }
            });
        });
        function dataIssue(datas){
            $.ajax({
                type: "GET",
                url: "{{ url('admin/show/issue-type') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    department_id:datas.department_id,
                    branch_id:datas.branch_id
                },
                dataType: "JSON",
                success: function(response) {
                    let data = response.data;
                    $('#issue-type').html('<option selected value=""> -- Select --</option>');
                    if (data !="") {
                        $.each(data, function(i, item) {
                            $('#issue-type').append($('<option>', {
                                value: item.id,
                                text: item.name,
                            }));
                        });
                    }
                }
            });
        }
    </script>
@endsection


@extends('layouts.admin')
@section('content')
<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Update ticket <span class="fw-300"><i>inputs</i></span>
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <form>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="ticket-subject" class="form-control required" id="e_ticket-subject">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-textarea">Description: <span class="text-danger">*</span></label>
                            <textarea class="form-control required" id="e_description" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-select2">
                            <label class="form-label" for="e_issue-type">Issue Type <span class="text-danger">*</span></label>
                            <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="e_issue-type">
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="form-group form-group-select2">
                            <label class="form-label" for="ticket-priority">Priority: <span class="text-danger">*</span></label>
                            <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="e_ticket_priority" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-assign">Assign this ticket to:</label>
                            <select class="select2 form-control w-100 select2-hidden-accessible" id="e_ticket-assign">
                                <option value="unassigned" selected> > Unassigned < </option>
                                <option value="auto-assign">  > Auto-assign <  </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-muted" for="ticket-due-date">Due date:</label>
                            <input class="form-control" id="e_due_date" type="date" name="date">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attachments:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="e_ticket-file">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-md-right">
                    <div class="btn-hidden-show">
                        <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                        <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn-update" type="button">Submit</button>
                    </div>
                    <input type="hidden" id="old_attachments">
                    <input type="hidden" value="{{csrf_token()}}" id="token"/>
                    <input type="hidden" name="" id="e_ticket_id">
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
            var url = window.location.pathname;
            var ticket_id = url.substring(url.lastIndexOf('/') + 1);
            $("#e_ticket_id").val(ticket_id);
            dataShow(ticket_id);

            $("#btn-update").on("click", function(e) {
                $(".btn-hidden-show").hide();
                $(".btn-loading").css('display', 'block');

                e.preventDefault();
                var formData = new FormData();
                var token = $("#token").val();
                var id =$("#e_ticket_id").val();
                let subject = $("input[name=e_ticket-subject]").val();
                var attachments = $('#e_ticket-file').prop('files')[0];
                var priority = $("#e_ticket_priority").val();
                var assignedby = $("#e_ticket-assign").val();
                var due_date = $("#e_due_date").val();
                var issue_type = $("#e_issue-type").val();
                var description = $("#e_description").val();
                var old_attachment = $("#old_attachments").val();
                // var fileSize = attachments['size'];

                formData.append('_token', token);
                formData.append('id', id);
                formData.append('attachments', attachments);
                formData.append('subject', subject);
                formData.append('priority', priority);
                formData.append('assignedby', assignedby);
                formData.append('due_date', due_date);
                formData.append('issue_type', issue_type);
                formData.append('message', description);
                formData.append('old_attachment', old_attachment);

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
                        url: "{{ url('admin/ticket/update') }}",
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
                                toastr.success(response.message);
                                var url = "{{ URL('admin/ticket/detail/') }}/" + $("#e_ticket_id").val();
                                window.location.replace(url); 
                            }
                        }
                    })
                }
            });
        });

        function dataShow(ticket_id){
            $.ajax({
                type: "GET",
                url: "{{ url('admin/ticket/show-one') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:ticket_id
                },
                dataType: "JSON",
                success: function(response) {
                    let data = response.data;
                    let issuetype = response.issuetype;
                    if (data) {
                        $("#e_ticket-subject").val(data.subject);
                        $("#e_description").val(data.message);
                        $("#e_due_date").val(data.due_date);
                        $("#e_ticket-assign").val(data.assignedby);
                        $("#old_attachments").val(data.attachments);
                        if (data.issue_type != '') {
                            $('#e_issue-type').html('<option selected value=""> -- Select --</option>');
                            $.each(issuetype, function(i, item) {
                                $('#e_issue-type').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == data.issue_type
                                }));
                            });
                        };
                        if (response.priority != '') {
                            $('#e_ticket_priority').html('<option selected value=""> -- Select --</option>');
                            $.each(response.priority, function(i, item) {
                                $('#e_ticket_priority').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == data.priority
                                }));
                            });
                        };
                    }
                }
            });
        }
    </script>
@endsection


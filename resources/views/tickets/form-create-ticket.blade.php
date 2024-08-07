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
            <div class="panel-tag">
                Required fields are marked with <span class="text-danger">*</span>
            </div>
            <form id="form-save-ticket">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label" for="ticket-name">Name: <span class="text-danger">*</span></label>
                            <input type="text" id="ticket-name" class="form-control required" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-email">Email: <span class="text-danger">*</span></label>
                            <input type="email" id="ticket-email" name="example-email-2" class="form-control required" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="ticket-subject" class="form-control required" id="ticket-subject" required>
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

                        <div class="form-group form-group-select2">
                            <label class="form-label">Issue Type: <span class="text-danger">*</span></label>
                            <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="issue-type" required>
                            </select>
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
                                <option value="auto-assign">  > Auto-assign <  </option>
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
                    <div class="col-xl-12 mt-3">
                        <div class="form-group">
                            <label class="form-label" for="ticket-textarea">Message: <span class="text-danger">*</span></label>
                            <textarea class="form-control required" id="ticket-textarea" rows="5" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-md-right">
                    <div class="btn-hidden-show">
                        <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                        <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn-save" type="button">Submit</button>
                    </div>
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
            var name_id = url.split("/")[4];
            var department_id = name_id.split("department")[1];
            var branch_id = name_id.split("branch")[1];
            let datas = {
                branch_id: branch_id,
                department_id: department_id
            };
            dataIssue(datas);
            $("#btn-save").on("click", function() {
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
                        data: {
                            "_token": "{{ csrf_token() }}",
                            department_id:              department_id,
                            branch_id:                  branch_id,
                            name:                       $("#ticket-name").val(),
                            email:                      $("#ticket-email").val(),
                            subject:                    $("#ticket-subject").val(),
                            priority:                   $("#ticket-priority").val(),
                            assignedby:                 $("#ticket-assign").val(),
                            due_date:                   $("#ticket-due-date").val(),
                            issue_type:                 $("#issue-type").val(),
                            overdue_email_sent:         $('input[name="ticket-notification"]:checked').val(),
                            satisfaction_email_sent:    $('input[name="ticket-check-submiss"]:checked').val(),
                            // attachments:        $("#ticket-file").val(),
                            message:            $("#ticket-textarea").val(),
                        },
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


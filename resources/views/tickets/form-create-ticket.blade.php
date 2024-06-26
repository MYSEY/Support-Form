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
            <form>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label" for="ticket-name">Name: <span class="text-danger">*</span></label>
                            <input type="text" id="ticket-name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-email">Email: <span class="text-danger">*</span></label>
                            <input type="email" id="ticket-email" name="example-email-2" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="ticket-subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-template">Select a ticket template:</label>
                            <select class="form-control" id="ticket-template">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ticket templates (<a type="button" href="#" >Manage ticket templates</a>)</label>
                            <div class="demo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="ticket-bottom" name="defaultExampleRadios" checked="">
                                    <label class="custom-control-label" for="ticket-bottom">Add to the bottom</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="ticket-replace-message" name="defaultExampleRadios">
                                    <label class="custom-control-label" for="ticket-replace-message">Replace message</label>
                                </div>
                            </div>
                        </div>

                        <div class="issue_types"></div>
                    </div>

                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label" for="ticket-proiority">Priority: <span class="text-danger">*</span></label>
                            <select class="form-control" id="ticket-proiority">
                                @foreach ($priority as $item)
                                    <option value="{{$item->id}}">{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ticket-assign">Assign this ticket to:</label>
                            <select class="form-control" id="ticket-assign">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
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
                                    <input type="checkbox" class="custom-control-input" id="ticket-notification" checked="">
                                    <label class="custom-control-label" for="ticket-notification">Send email notification to the customer</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="ticket-check-submiss" checked="">
                                    <label class="custom-control-label" for="ticket-check-submiss">Show the ticket after submissio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-3">
                        <div class="form-group">
                            <label class="form-label" for="ticket-textarea">Message: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ticket-textarea" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-md-right">
                    <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                    <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn-save" type="button">Submit</button>
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
            dataIssueType({"department_id":department_id, "branch_id": branch_id});

            $("#btn-save").on("click", function() {
                alert(34567890);
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/issue-type') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        department_id:ids.department_id,
                        branch_id:ids.branch_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        let data = response.data;
                        console.log(data);
                    }
                })
            });
        });
        

        function dataIssueType(ids){
            $.ajax({
                type: "POST",
                url: "{{ url('admin/issue-type/ids') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    department_id:ids.department_id,
                    branch_id:ids.branch_id
                },
                dataType: "JSON",
                success: function(response) {
                    let datas = response.data;
                    console.log("response: ",datas);
                    if (datas.length > 0) {
                        let issue_type = '';
                        datas.map((item) => {
                            let checks = "";
                            if (item.type == "checkbox") {
                                let text = item.value.split("\n");
                                text.map((check,index) => {
                                    checks +='<div class="custom-control custom-checkbox">'+
                                            '<input type="checkbox" class="custom-control-input checkbox_issue_type" id="checkod_'+index+'">'+
                                            '<label class="custom-control-label" for="checkod_'+index+'">'+check+'</label>'+
                                        '</div>';
                                })
                                issue_type +='<div class="form-group">'+
                                                '<label class="form-label">'+item.name+'</label>'+
                                                '<div class="demo">'+
                                                    checks+
                                                '</div>'+
                                            '</div>';
                            };
                            if (item.type == "radio") {
                                let text = item.value.split("\n");
                                text.map((check,index) => {
                                    checks +='<div class="custom-control custom-radio">'+
                                            '<input type="radio" class="custom-control-input checkbox_issue_type" id="issueRadio_'+index+'">'+
                                            '<label class="custom-control-label" for="issueRadio_'+index+'">'+check+'</label>'+
                                        '</div>';
                                })
                                issue_type +='<div class="form-group">'+
                                                '<label class="form-label">'+item.name+'</label>'+
                                                '<div class="demo">'+
                                                    checks+
                                                '</div>'+
                                            '</div>';
                            }
                            if (item.type == "select") {
                                let text = item.value.split("\n");
                                text.map((check,index) => {
                                    checks +='<option>'+check+'</option>';
                                })
                                issue_type +='<div class="form-group">'+
                                                '<label class="form-label">'+item.name+'</label>'+
                                                '<select class="form-control checkbox_issue_type">'+
                                                    '<option></option>'+
                                                    checks+
                                                '</select>'+
                                            '</div>';
                                            $(".issue_types").addClass("form-group");
                            }
                            if (item.type == "text") {
                                issue_type +='<div class="form-group">'+
                                                '<label class="form-label">'+item.name+'</label>'+
                                                '<p>'+item.value+'</p>'+
                                            '</div>';
                            }
                        });
                        $(".issue_types").append(issue_type);
                    }
                }
            });
        }
    </script>
@endsection


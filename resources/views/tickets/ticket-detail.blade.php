@extends('layouts.admin')
@section('content')
<style>
    .ticket-status {
        color: red;
    }
    .mark-as-resolved {
        color: blue;
    }
    .priority-high {
        color: orange;
    }
    .assign-link {
        color: blue;
    }
    .ticket-info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
</style>
    <input type="hidden" name="id" id="e_id_ticket" value="{{$data_ticket->id}}">
    <div class="row">
        <div class="col-md-8">
            <div id="panel-1" class="panel panel-sortable" role="widget">
                <div class="panel-hdr">
                    <h2>
                        {{$data_ticket->subject}} <span class="fw-300"><i></i></span>
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content poisition-relative">
                        {{-- <h3>{{$data_ticket->subject}}</h3><br> --}}
                        <h5 class="card-title">Contact: <span class="text-primary">{{$data_ticket->name}} ,</span>
                            <span class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}</span>
                        </h5>
                        <p class="card-text">Issue Type: {{$data_ticket->issueType->name}}</p>
                        <p class="card-text">
                            {!! nl2br(e($data_ticket->message)) !!}
                        </p>
                        <p class="card-text"><a href="{{url("storage/attachments",$data_ticket->attachments)}}" target="_blank">{{$data_ticket->attachments}}</a></p>

                        <div id="show-notes"> </div>
                        @can('Ticket Add Note')
                            <button class="btn btn-outline-success" id="btn-add-note">Add note</button>
                        @endcan
                        <div class="form-noted mt-3" style="display: none;">
                            <div class="form-group">
                                <label class="form-label" for="ticket-textarea">Message: <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ticket-textarea" rows="5"></textarea>
                            </div>
                            {{-- <div class="form-group">
                                <input type="file" id="attachments" class="form-control-file">
                            </div> --}}
                            <div class="btn-loading-noted" style="display: none">
                                <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                            <div class="btn-hidden-show-noted">
                                <button class="btn btn-danger" id="btn-save-note">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panel-2" class="panel panel-sortable" role="widget">
                <div class="panel-hdr">
                    <h2>
                        Apply Ticket<span class="fw-300"><i></i></span>
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content poisition-relative">
                        <div id="show-replies"> </div>
                        <div class="form mt-3">
                            <div class="form-group">
                                <textarea class="form-control" id="ticket-reply" rows="5"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-select2">
                                        <label class="form-label" for="ticket-assigned">Assigned to: </label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="ticket-assigned" required>
                                            <option value="unassigned">> Unassigned <</option>
                                            <option value="auto-assign">> Auto-assign <</option>
                                            @if (count($user_support) > 0)
                                                @foreach ($user_support as $item)
                                                    <option @if($item->id == $data_ticket->assignedby) selected @endif value="{{$item->id}}">{{ $item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Attachments:</label>
                                        <div class="custom-file">
                                            <input type="file" id="rp_attachments" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="form-group frame-wrap">
                                        <div class="demo" style="display: flex">
                                            <div class="custom-control custom-checkbox ">
                                                <input type="checkbox" class="custom-control-input" id="autostart" checked="">
                                                <label class="custom-control-label mr-3" for="autostart">Attach signature ( Profile settings )</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="autoreload-send-email" name="autoreload-send-email">
                                            <label class="custom-control-label" for="autoreload-send-email">Don't send email notification of this reply to the customer</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-select2">
                                        <label class="form-label" for="ticket-status">Ticket status:</label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="ticket-status" required>
                                            <option value=""></option>
                                            @if (count($status) > 0)
                                                @foreach ($status as $item)
                                                    <option @if($item->id == $data_ticket->status) selected @endif value="{{$item->id}}">{{ $item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group form-group-select2">
                                        <label class="form-label" for="ticket-priority">Priority: </label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="ticket-priority" required>
                                            <option value=""></option>
                                            @if (count($priority) > 0)
                                                @foreach ($priority as $item)
                                                    <option @if($item->id == $data_ticket->priority) selected @endif style="color: {{$item->color}}" value="{{$item->id}}">{{ $item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                            @can('Ticket Reply')
                                <div class="btn-loading" style="display: none">
                                    <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                                <input type="hidden" value="{{csrf_token()}}" id="token"/>
                                <div class="btn-hidden-show">
                                    <button class="btn btn-danger" id="btn-reply-ticket">Submit Reply</button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="btn-group btn-group-custom d-flex justify-content-end" role="group" aria-label="Print Options">
                @can('Ticket Edit')
                    <a class="btn btn-outline-primary" href="{{url("admin/ticket/edit")}}/{{$data_ticket->id}}"><i class="fal fa-edit"></i> Edit</a>
                @endcan
                @can('Ticket Print')
                    <button type="button" class="btn btn-outline-primary btn-print"> <span class="fal fa-print mr-1"></span> Print</button>
                @endcan
                <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"><i class="fal fa-envelope"></i> Re-send email notification</a>
                    @can('Ticket Export')
                        <a class="dropdown-item" href="#"><i class="fal fa-arrow-to-bottom"></i> Export to Excel</a>
                    @endcan
                    @can('Ticket Delete')
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket"><i class="fal fa-trash-alt"></i> Delete ticket</a>
                    @endcan
                </div>
            </div>
           
            {{-- Block Detail Tickets --}}
            <div class="frame-wrap w-100 mt-4">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Ticket Details
                                <span class="ml-auto">
                                    <span class="collapsed-reveal">
                                        <i class="fal fa-angle-up"></i>
                                        {{-- <i class="fal fa-minus-circle text-danger"></i> --}}
                                    </span>
                                    <span class="collapsed-hidden">
                                        <i class="fal fa-angle-down"></i>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <p class="card-text">Tracking ID: <strong class="ml-3">{{$data_ticket->trackid}}</strong></p>
                                <p class="card-text">Ticket number: <strong class="ml-3">{{$data_ticket->id}}</strong></p>
                                <p class="card-text">Created on: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}</strong></p>
                                <p class="card-text">Updated: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->updated_at)->format('d-M-Y h:i A') ?? '' }}</strong></p>
                                <p class="card-text">Replies: <strong class="ml-3" id="total_replies">0</strong></p>
                                <p class="card-text">Last replier: <strong class="ml-3">{{$data_ticket->lastReplier ? $data_ticket->lastReplier->name : ""}}</strong></p>
                                {{-- <p class="card-text">Time worked: <strong class="ml-3">00:00</strong></p> --}}
                                <p class="card-text">Due date: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->due_date)->format('d-M-Y') ?? '' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Block Histories --}}
            <div class="frame-wrap w-100">
                <div class="accordion" id="History">
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <a href="javascript:void(0);" class="card-title collapsed show" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Ticket History
                                <span class="ml-auto">
                                    <span class="collapsed-reveal">
                                        <i class="fal fa-angle-up"></i>
                                        {{-- <i class="fal fa-minus-circle text-danger"></i> --}}
                                    </span>
                                    <span class="collapsed-hidden">
                                        <i class="fal fa-angle-down"></i>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#History">
                            <div class="card-body">
                                <ul>
                                    @if (count($data_ticket->histories) > 0)
                                        @foreach ($data_ticket->histories as $item)
                                            @if ($item->type == "new")
                                                <li><strong>Ticket created by</strong>
                                                    <ul style="list-style-type:none;">
                                                        <li>{{$item->createdBy->user}} at {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}</li>
                                                    </ul>
                                                </li>
                                                {{-- <li> <p>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">ticket created by {{$item->createdBy->name}}</strong></p></li> --}}
                                            @endif
                                            @if ($item->type == "status")
                                                <li><strong>Status changed </strong>
                                                    <ul style="list-style-type:none;">
                                                        <li>From <strong style="color: {{$item->statusFrom->color}}">{{$item->statusFrom->name}}</strong> to <strong style="color: {{$item->statusTo->color}}">{{$item->statusTo->name}}</strong> by user change {{$item->createdBy->user}} at {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}</li>
                                                    </ul>
                                                </li>
                                            {{-- <li> <p class="card-text">{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">Status changed from {{$item->statusFrom->name}} to {{$item->statusTo->name}} by user change {{$item->createdBy->name}}</strong></p></li>  --}}
                                            @endif
                                            @if ($item->type == "priority")
                                                <li><strong>Priority changed </strong>
                                                    <ul style="list-style-type:none;">
                                                        <li>From <strong style="color: {{$item->priorityFrom->color}}">{{$item->priorityFrom->name}}</strong> to <strong style="color: {{$item->priorityTo->color}}">{{$item->priorityTo->name}}</strong> by user change {{$item->createdBy->user}} at {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}</li>
                                                    </ul>
                                                </li>
                                            {{-- <li> <p class="card-text">{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">Priority changed from {{$item->priorityFrom->name}} to {{$item->priorityTo->name}} by user change {{$item->createdBy->name}}</strong></p></li>  --}}
                                            @endif
                                            @if ($item->type == "assign")
                                                <li><strong>Assignee</strong>
                                                    <ul style="list-style-type:none;">
                                                        <li>From <strong>{{$item->assignedBy ? $item->assignedBy->user : "null"}}</strong> to <strong>{{$item->recipient ? $item->recipient->user : "null"}}</strong> at {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}</li>
                                                    </ul>
                                                </li>
                                            {{-- <li> <p class="card-text">{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">Assignee from {{$item->assignedBy->name}} to {{$item->recipient->name}}</strong></p></li>  --}}
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal custom-modal fade" id="delete_ticket" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form>
                            @csrf
                            {{-- <input type="hidden"  name="id" class="e_id" value="{{$data_ticket->id}}"> --}}
                            <div class="float-lg-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger waves-effect waves-themed btn-delete-ticket" data-id="{{$data_ticket->id}}">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('tickets.noted')
    @include('tickets.replies')
    @include('tickets.print_ticket_detail')
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript" src="{{ asset('/admins/js/printThis.js') }}"></script>
    <script type="text/javascript">
        var userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
        $(function(){
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);

            $(document).on('click','.btn-update-status', function(){
                let status_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/ticket/update/status')}}",
                    data: {
                        "_token":       "{{ csrf_token() }}",
                        id:             id,
                        status:         status_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == "error") {
                            toastr.error(response.message);
                        }else{
                            toastr.success('Status update successfully.');
                            var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                            window.location.replace(url); 
                        }
                    }
                });
            });
            $(document).on('click','.btn-update-assignedto', function(){
                let assigned_to = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/ticket/update/assignedto')}}",
                    data: {
                        "_token":       "{{ csrf_token() }}",
                        id:             id,
                        assigned_to:    assigned_to
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == "error") {
                            toastr.error(response.message);
                        }else{
                            toastr.success('priority update successfully.');
                            var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                            window.location.replace(url); 
                        }
                    }
                });
            });
            $(document).on('click','.btn-update-priority', function(){
                let priority_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/ticket/update/priority')}}",
                    data: {
                        "_token":       "{{ csrf_token() }}",
                        id:             id,
                        priority:       priority_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == "error") {
                            toastr.error(response.message);
                        }else{
                            toastr.success('priority update successfully.');
                            var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                            window.location.replace(url); 
                        }
                    }
                });
            });

            $(".btn-print").on("click", function() {
                print_pdf();
            });

            $(document).on('click','.btn-delete-ticket', function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/ticket/delete')}}",
                    data: {
                        "_token":       "{{ csrf_token() }}",
                        id:             id,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        toastr.success('Ticket deleted successfully.');
                        setTimeout(function() {
                            var url = "{{ URL('admin/ticket') }}";
                            window.location.replace(url); 
                        }, 1500);
                    }
                });
            });

            //** block noted
            showNote(id)
            $("#btn-add-note").click(function(){
                $(".form-noted").toggle();
                $("#ticket-textarea").addClass("is-valid");
                $("#ticket-textarea").removeClass("is-invalid");
            });
            $(document).on('click','#btn-note-edit', function(){
                let id = $(this).data("id");
                let message = $(this).data("message");
                $("#e_id_note").val(id);
                $("#e_message_note").val(message);
                $('#editNote').modal('show');
            });
            $(document).on('click','#btn-note-delete', function(){
                let id = $(this).data("id");
                $("#d_id_note").val(id);
                $('#delteNote').modal('show');
            });
            $("#btn-save-note").click(function() {
                $(".btn-hidden-show-noted").hide();
                $(".btn-loading-noted").css('display', 'block');

                if ($("#ticket-textarea").val() == null || $("#ticket-textarea").val() == "") {
                    $("#ticket-textarea").addClass("is-invalid");
                    $("#ticket-textarea").removeClass("is-valid");
                    $(".btn-hidden-show-noted").show();
                    $(".btn-loading-noted").css('display', 'none');
                    toastr.error("Please input text!");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/note/save')}}",
                        data: {
                            "_token":                   "{{ csrf_token() }}",
                            ticket_id:                  $("#e_id_ticket").val(),
                            message:                    $("#ticket-textarea").val(),
                            // attachments:             $("#attachments").val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Data create successfully.');
                                // var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                                var url = "{{ URL('admin/ticket/') }}";
                                window.location.replace(url); 
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(error);
                        }
                    });
                }
            });

            //** block reply ticket
            showReplies(id)
            $("#btn-reply-ticket").click(function(e) {
                $(".btn-hidden-show").hide();
                $(".btn-loading").css('display', 'block');

                e.preventDefault();
                var formData = new FormData();
                var token = $("#token").val();
                var reply_to = $("#e_id_ticket").val();
                var ticketReply = $("#ticket-reply").val();
                var message = $("#ticket-reply").val();
                var message_html = $("#ticket-reply").val();
                var priority = $("#ticket-priority").val();
                var status = $("#ticket-status").val();
                var assignedby = $("#ticket-assigned").val();
                var autoreload = $('input[name="autoreload-send-email"]:checked').val();
                var rp_attachments = $("#rp_attachments").prop('files')[0];

                formData.append('_token', token);
                formData.append('reply_to', reply_to);
                formData.append('message', message);
                formData.append('message_html', message_html);
                formData.append('priority', priority);
                formData.append('status', status);
                formData.append('assignedby', assignedby);
                formData.append('autoreload', autoreload);
                formData.append('rp_attachments', rp_attachments);
                
                if ($("#ticket-reply").val() == null || $("#ticket-reply").val() == "") {
                    $("#ticket-reply").addClass("is-invalid");
                    $("#ticket-reply").removeClass("is-valid");
                    $(".btn-hidden-show").show();
                    $(".btn-loading").css('display', 'none');
                    toastr.error("Please input text!");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/ticket/replies')}}",
                        data: formData,
                        contentType: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success(response.message);
                                // var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                                var url = "{{ URL('admin/ticket/') }}";
                                window.location.replace(url); 
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(error);
                        }
                    });
                }
            });
            $(document).on('click','#btn-reply-edit', function(){
                let id = $(this).data("id");
                let message = $(this).data("message");
                $("#e_id_reply").val(id);
                $("#e_message_reply").val(message);
                $('#editReplyTicket').modal('show');
            });
            $(document).on('click','#btn-reply-delete', function(){
                let id = $(this).data("id");
                $("#d_id_reply").val(id);
                $('#delteReply').modal('show');
            });

        });
        function nl2br(str) {
            return str.replace(/\n/g, '<br>');
        }
        function showNote(ticket_id){
            $.ajax({
                type: "GET",
                url: "{{url('admin/note/show')}}",
                data: {
                    ticket_id:ticket_id
                },
                dataType: "JSON",
                success: function (response) {
                    let datas = response.datas;
                    let text = "";
                    let note_tr = "";
                    if (datas.length > 0) {
                        datas.forEach(function(value, index) {
                            var message = nl2br(value.message);
                            let created_at = moment(value.updated_at).format('D-MMM-YYYY h:mm');
                            text +='<div class="panel-tag">'+
                                    '<div>';
                                        if (userPermissions.includes('Ticket Delete Note')) {
                                            text += '<a style="float: right;" href="javascript:void(0);" id="btn-note-delete" data-id="'+value.id+'" data-toggle="tooltip" title="Delete" class="btn btn-outline-primary btn-sm btn-icon waves-effect waves-themed">'+
                                                '<i class="fal fa-trash-alt"></i>'+
                                            '</a>';
                                        }
                                        if (userPermissions.includes('Ticket Edit Note')) {
                                            text += '<a style="float: right;" href="javascript:void(0);" id="btn-note-edit" data-id="'+value.id+'" data-message="'+value.message+'" data-toggle="tooltip" title="Edit" class="mr-1 btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed">'+
                                                '<i class="fal fa-edit"></i>'+
                                            '</a>';
                                        }
                                        text += '<p class="card-text">Note by: <strong>'+value.created_by.user+'</strong> » '+created_at+'</p>'+
                                    '</div>'+
                                    '<p class="card-text mt-2">'+message+'</p>'+
                                '</div>';
                                note_tr +='<tr>'+
                                                '<td class="table_tr">'+
                                                    '<strong>Note by: '+value.created_by.user+'</strong> » '+created_at+'<br>'
                                                    +message+
                                                '</td>'+
                                            '</tr>';
                        });

                        $("#show-notes").html(text);
                        $(".tbl-noted").html(note_tr);
                    }
                }
            });
        }

        function showReplies(ticket_id){
            $.ajax({
                type: "GET",
                url: "{{url('admin/replies/show')}}",
                data: {
                    ticket_id:ticket_id
                },
                dataType: "JSON",
                success: function (response) {
                    let datas = response.datas;
                    let text = "";
                    let reply_tr = "";
                    $("#total_replies").text(datas.length);
                    if (datas.length > 0) {
                        let btn_delete = "";
                        datas.forEach(function(value, index) {
                            var message = nl2br(value.message);
                            let created_at = moment(value.updated_at).format('D-MMM-YYYY h:mm');
                            if (userPermissions.includes('Ticket Delete Reply')) {
                                btn_delete = '<a class="dropdown-item" href="javascript:void(0);" id="btn-reply-delete" data-id="'+value.id+'"><i class="fal fa-trash-alt"></i> Delete reply</a>';
                            }
                            text +='<div class="panel-tag">'+
                                    '<div>'+
                                        '<button style="text-decoration: none !important; float: right;" class="btn btn-link dropdown-toggle p-0" type="button" id="ticketStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> More </button>'+
                                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="ticketStatus">'+
                                            '<a class="dropdown-item" href="javascript:void(0);"><i class="fal fa-envelope"></i> Re-send email notification</a>'+
                                            (btn_delete)+
                                        '</div>';
                                        if (userPermissions.includes('Ticket Edit Reply')) {
                                            text += '<a style="float: right;" href="javascript:void(0);" class="mr-2 btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed" id="btn-reply-edit" data-id="'+value.id+'" data-message="'+value.message+'" data-toggle="tooltip" title="Edit">'+
                                                '<i class="fal fa-edit"></i>'+
                                            '</a>';
                                        }
                                        text += '<p class="card-text">Reply by: <strong>'+value.staff.user+'</strong> » '+created_at+'</p>'+
                                    '</div>'+
                                    '<p class="card-text mt-2">'+message+'</p>'+
                                    '<p class="card-text"><i class="fal fa-trash-alt"></i> <a href="{{url("storage/attachments")}}/'+(value.attachments)+'" target="_blank">'+value.attachments+'</a></p>'+
                                '</div>';
                                reply_tr  +='<tr>'+
                                                '<td class="table_tr">'+
                                                    '<strong>Reply by: '+value.staff.user+'</strong> » '+created_at+'<br>'
                                                    +message+
                                                '</td>'+
                                            '</tr>';
                                
                        });
                        $("#show-replies").html(text);
                        $(".tbl-reply").html(reply_tr);
                    }
                }
            });
        }
        function print_pdf() {
        $("#print_purchase").show();
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admins/css/style_table.css')}}",
            header: "",
            printDelay: 1500,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    </script>
@endsection
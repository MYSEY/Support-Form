@extends('layouts.admin')
@section('content')
@can('Ticket Create')
    <div class="demo">
        {{-- href="{{url('admin/ticket/create')}}" --}}
        <a type="button" id="btn-crearte" href="#" data-toggle="modal" data-target="#modal-select" class="btn btn-danger waves-effect waves-themed float-right">Create New Ticket</a>
        @can('Ticket Import')
            <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger waves-effect waves-themed float-right">Import</a>
        @endcan
    </div>
@endcan
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item"><a class="nav-link active tab-tables" data-toggle="tab" data-permiss="1" href="#open_ticket">Open tickets {{$total_all_ticket}}</a></li>
    @if (Auth::user()->RolePermission !='staff')
        <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="2" href="#ticke_assigned">Assigned to me {{$total_assigned_ticket}}</a></li>
        {{-- <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="3" href="#js_change_pill_direction-3">Assigned to others {{$total_others_ticket}}</a></li> --}}
        <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="4" href="#ticket_unassigned">Unassigned {{$total_unassigned_ticket}}</a></li>
    @endif
    <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="5" href="#ticket_due_soon">Due soon {{$total_due_soon_ticket}}</a></li>
    <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="6" href="#tiecket_overdue">Overdue {{$total_overdue_ticket}}</a></li>
</ul>

<div class="row mt-3">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Ticket List
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <div class="tab-content py-3">
                            @include('tickets.table-tickets')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="modal-select" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><strong>Please click on the section to support you!</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if (count($department)>0)
                        <div class="col-md-12">
                            <div class="form-group">
                                {{-- <label class="form-label" for="simpleinput">Department</label> --}}
                                <div class="dropdown-menu d-block position-relative float-none">
                                    @foreach ($department as $item)
                                        <a class="dropdown-item" href="{{url('admin/ticket/view-guidelines/'.$item->id)}}">
                                            <span class="float-right"><i class="fal fa-angle-right" style="font-size: 20px"></i></span>{{$item->name_english}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- @if (count($branch)>0)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Branch</label>
                                <div class="dropdown-menu d-block position-relative float-none">
                                    @foreach ($branch as $item)
                                        <a class="dropdown-item" href="{{url('admin/ticket/create','branch'.$item->id)}}">
                                            <span class="float-right"><i class="fal fa-angle-right" style="font-size: 20px"></i></span>{{ $item->branch_name_en}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- import datas --}}
<div class="modal fade show" id="modal-import" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><strong>Import datas!</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Import excel/ XLS,XLSX or CSV</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert thanLess" style="display:none;background-color:#F7D7DA">
                                <span id="thanLess"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file">
                            </div>
                        </div><br>
                        <div class="text-end float-right">
                            <div class="btn-hidden-show">
                                <button class="btn btn-primary waves-effect waves-themed submit-btn upload_file_data" type="button">Submit</button>
                            </div>
                            <div class="btn-impot-loading mt-3" style="display: none">
                                <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    @include('includs.datatables_export')
    <script type="text/javascript">
        $(function(){
            // $(document).ready(function(){
            //     $('#dt-basic-assign').DataTable();
            //     $('#dt-basic-assign-other').DataTable();
            //     $('#dt-basic-unassigned').DataTable();
            //     $('#dt-basic-due-soon').DataTable();
            //     $('#dt-basic-overdue').DataTable();
            //     $('[data-toggle="tooltip"]').tooltip(); 
            // });
            $('.tab-tables').each(function() {
                if ($(this).hasClass('active')) {
                    var dataId = $(this).attr('data-permiss');
                    showDatas(dataId);
                }
            });
            $(".tab-tables").on("click", function(){
                let tab_status = $(this).attr('data-permiss');
                showDatas(tab_status);
            });

            $(".upload_file_data").on("click", function() {
                if ($('#result_file').val() == "") {
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css(
                        "color", "red");
                    $(".thanLess").show();
                    return false;
                }
                var file_data = $('#result_file').prop('files')[0];
                var fileName = file_data['name'];
                var form_data = new FormData();
                var fileExtension = fileName.split('.').pop();
                var fileSize = file_data['size'];
                form_data.append('file', file_data);
                form_data.append('_token', "{{ csrf_token() }}");
                if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {

                    $(".upload_file_data").prop('disabled', true);
                    $(".btn-hidden-show").hide();
                    $(".btn-impot-loading").css('display', 'block');

                    $("#modal-import").modal("show");
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/ticket/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data == 1) {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/ticket') }}");
                            }
                            if (data == 2) {
                                $("#modal-import").modal("hide");
                                $("#thanLess").text("Data duplicate").css("color", "red");
                                $(".thanLess").show();
                            }
                            if (data == 0) {
                                $("#modal-import").modal("show");
                                data == 0;
                                $("#thanLess").text(
                                    "Please select a xls,xlsx and csv file and size less then 1MB"
                                    ).css("color", "red");
                                $(".thanLess").show();
                            }
                            $(".btn-hidden-show").show();
                            $(".btn-impot-loading").css('display', 'none');
                            $(".upload_file_data").prop("disabled",false);
                        }
                    });
                }else{
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css(
                        "color", "red");
                    $(".thanLess").show();
                }
            });
        });
        function nl2br(str) {
            return str.replace(/\n/g, '<br>');
        }
        function showDatas(tab){
            $.ajax({
                type: "GET",
                url: "{{ url('admin/ticket/show') }}",
                data: {
                    status: tab
                },
                dataType: "JSON",
                success: function(response) {
                    let datas = response.datas
                    var bodyTr = "";
                    if (datas.length > 0) {
                        // let message ="";
                        datas.forEach(function(value, index) {
                            let created_at = moment(value.created_at).format('D-MMM-YYYY');
                            let updated_at = moment(value.updated_at).format('D-MMM-YYYY');
                            let due_date = value.due_date ? moment(value.due_date).format('D-MMM-YYYY') : "";
                            let assign_by = value.assignedTo;

                            if (value.assigned_to) {
                                assign_by = "Assigned to: "+value.assigned_to.name;
                            }
                            let ticket_type = "Normal";
                            if (value.ticket_type == 1) {
                                ticket_type = "Specail Case";
                            }
                            // var message = nl2br(value.message);
                            // message = removeBrTags(value.message);
                            
                            bodyTr +='<tr>'+
                                    '<td><a href="{{url("admin/ticket/detail")}}/'+(value.id)+'">'+(value.trackid)+'</a></td>'+
                                    '<td><a href="{{url("admin/ticket/detail")}}/'+(value.id)+'">'+(created_at)+'</a></td>'+
                                    '<td>'+(value.from_department ? value.from_department.name_english : "")+(value.branch ? value.branch.branch_name_en : "")+'</td>'+
                                    '<td>'+value.name+'</td>'+
                                    '<td>'+(value.department ? value.department.name_english: "")+'</td>'+
                                    '<td class="sub-issue-type sub-message" data-assign-by="'+(assign_by)+'" data-message="'+(value.message)+'">'+
                                        '<a href="javascript:void(0)">'+value.subject+'</a>'+
                                    '</td>'+
                                    '<td style="color: '+value.custom_status.color+'">'+value.custom_status.name+'</td>'+
                                    '<td >'+(ticket_type)+'</td>'+
                                    '<td class="sub-issue-type" data-toggle="tooltip" data-html="true" title="'+(value.issue_type ? value.issue_type.name : "")+'">'+(value.issue_type ? value.issue_type.name : "")+'</td>'+
                                    '<td>'+
                                        '<div style="display: flex">'+
                                            '<i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:'+value.priorities.color+'"></i> <span>'+(value.priority ? value.priorities.name : "")+'</span>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+(value.assigned_to ? value.assigned_to.name : value.assignedTo)+'</td>'+
                                    '<td>'+(value.last_replier ? value.last_replier.name : value.name)+'</td>'+
                                    '<td>'+due_date+'</td>'+
                                    '<td>'+updated_at+'</td>'+
                                    '<td><a href="{{url("storage/attachments")}}/'+(value.attachments)+'" target="_blank">'+(value.attachments)+'</a></td>'+
                                '</tr>';
                        });
                    }
                    $.fn.dataTable.ext.errMode = 'none';
                    
                    if (tab == 1) {
                        $("#dt-basic-all tbody").html(bodyTr);
                        $('#dt-basic-all').DataTable();
                    }
                    if (tab == 2) {
                        $("#dt-basic-assign tbody").html(bodyTr);
                        $('#dt-basic-assign').dataTable()
                    }
                    if (tab == 3) {
                        $("#dt-basic-assign-other tbody").html(bodyTr);
                        $('#dt-basic-assign-other').dataTable()
                    }
                    if (tab == 4) {
                        $("#dt-basic-unassigned tbody").html(bodyTr);
                        $('#dt-basic-unassigned').dataTable()
                    }
                    if (tab == 5) {
                        $("#dt-basic-due-soon tbody").html(bodyTr);
                        $('#dt-basic-due-soon').dataTable()
                    }
                    if (tab == 6) {
                        $("#dt-basic-overdue tbody").html(bodyTr);
                        $('#dt-basic-overdue').dataTable()
                    }
                    
                    $('.sub-issue-type').each(function() {
                        var text = $(this).text();
                        var limit = 20; // Set your character limit
                        if (text.length > limit) {
                            var truncated = text.substring(0, limit) + '...';
                            $(this).text(truncated);
                        }
                    });
                    $(document).ready(function() {
                        function removeBrTags(input) {
                            return input.replace(/<br\s*\/?>/gi, '');
                        }
                        $('.sub-message').each(function() {
                            var assignBy = $(this).data('assign-by');
                            var message = $(this).data('message');

                            var cleanedMessage = removeBrTags(message);
                            var tooltipContent = assignBy + ' » ' + cleanedMessage;

                            $(this).attr('data-toggle', 'tooltip')
                                .attr('data-html', 'true')
                                .attr('title', tooltipContent);
                        });
                    });
                    
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }
    </script>
@endsection


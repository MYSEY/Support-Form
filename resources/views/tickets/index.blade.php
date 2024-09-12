@extends('layouts.admin')
@section('content')
@can('Ticket Create')
    <div class="demo">
        {{-- href="{{url('admin/ticket/create')}}" --}}
        <a type="button" id="btn-crearte" href="#" data-toggle="modal" data-target="#modal-select" class="btn btn-danger waves-effect waves-themed float-right">Create New Ticket</a>
    </div>
@endcan
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item"><a class="nav-link active tab-tables" data-toggle="tab" data-permiss="1" href="#js_change_pill_direction-1">Open tickets {{$total_all_ticket}}</a></li>
    @if (Auth::user()->RolePermission !='staff')
        <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="2" href="#js_change_pill_direction-2">Assigned to me {{$total_assigned_ticket}}</a></li>
        {{-- <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="3" href="#js_change_pill_direction-3">Assigned to others {{$total_others_ticket}}</a></li> --}}
        <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="4" href="#js_change_pill_direction-4">Unassigned {{$total_unassigned_ticket}}</a></li>
    @endif
    <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="5" href="#js_change_pill_direction-5">Due soon {{$total_due_soon_ticket}}</a></li>
    <li class="nav-item"><a class="nav-link tab-tables" data-toggle="tab" data-permiss="6" href="#js_change_pill_direction-6">Overdue {{$total_overdue_ticket}}</a></li>
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
                            let assign_by = value.assignedby;
                            if (value.assigned_by) {
                                assign_by = "Assigned to: "+value.assigned_by.name;
                            }
                            // var message = nl2br(value.message);
                            // message = removeBrTags(value.message);
                            
                            bodyTr +='<tr>'+
                                    '<td><a href="{{url("admin/ticket/detail")}}/'+(value.id)+'">'+(value.trackid)+'</a></td>'+
                                    '<td><a href="{{url("admin/ticket/detail")}}/'+(value.id)+'">'+(created_at)+'</a></td>'+
                                    '<td>'+updated_at+'</td>'+
                                    '<td>'+(value.department ? value.department.name_english: "")+'</td>'+
                                    '<td>'+value.name+'</td>'+
                                    '<td class="sub-issue-type sub-message" data-assign-by="'+(assign_by)+'" data-message="'+(value.message)+'">'+
                                        '<a href="javascript:void(0)">'+value.subject+'</a>'+
                                    '</td>'+
                                    '<td><a href="{{url("storage/attachments")}}/'+(value.attachments)+'" target="_blank">'+(value.attachments)+'</a></td>'+
                                    '<td style="color: '+value.custom_status.color+'">'+value.custom_status.name+'</td>'+
                                    '<td>'+(value.assigned_by ? value.assigned_by.name : value.assignedby)+'</td>'+
                                    '<td>'+(value.last_replier ? value.last_replier.name : value.name)+'</td>'+
                                    '<td>'+due_date+'</td>'+
                                    '<td class="sub-issue-type" data-toggle="tooltip" data-html="true" title="'+(value.issue_type ? value.issue_type.name : "")+'">'+(value.issue_type ? value.issue_type.name : "")+'</td>'+
                                    '<td>'+
                                        '<div style="display: flex">'+
                                            '<i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:'+value.priorities.color+'"></i> <span>'+(value.priority ? value.priorities.name : "")+'</span>'+
                                        '</div>'+
                                    '</td>'+
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


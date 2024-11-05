@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row filter-btn">
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="" placeholder="From Date">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="To Date">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <select class="select2-placeholder-multiple form-control select2-hidden-accessible" id="priority" data-select2-id="select2-data-2-c0n2" name="priority">
                                    <option value="">-- Select Priority --</option>
                                    @foreach ($priority as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2-placeholder-multiple form-control select2-hidden-accessible"
                                    multiple="" id="status" data-select2-id="multiple-placeholder"
                                    tabindex="-1" aria-hidden="true">
                                    @foreach ($status as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed" id="btnSearch">Search</a>
                            {{-- <a href="#" title="Export" data-filter-tags="datatables datagrid export tables pdf excel print csv">
                                <span class="nav-link-text" data-i18n="nav.datatables_export">Export</span>
                            </a> --}}
                            @can('Ticket Report Export')
                                <a  href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Ticket Report
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table data-order='[[ 4, "desc" ]]'  id="dt-basic-ticket-report" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Tracking_ID</th>
                                        <th>Submitted</th>
                                        <th>From_Department/Branch</th>
                                        <th>Create_By</th>
                                        <th>To_Department</th>
                                        <th>Subjesct</th>
                                        <th>Status</th>
                                        <th>Ticket_Type</th>
                                        <th>Sub_Issue_Type</th>
                                        <th>Priority</th>
                                        <th>Assigned</th>
                                        <th>Last_Replier</th>
                                        <th>Due_Date</th>
                                        <th>Updated</th>

                                        {{-- <th>Tranking ID</th>
                                        <th>Subject</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Submited Date</th>
                                        <th>Department</th>
                                        <th>Priority</th>
                                        <th>Owner</th>
                                        <th>Issue Type</th>
                                        <th>Status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
        $(document).ready(function(){
            showTickeReport();
            $("#btnSearch").on("click", function() {
                // $("#dt-basic-ticket-report tbody").empty();
                // let param = {
                //     "_token": "{{ csrf_token() }}",
                //     status: $("#status").val(),
                //     priority: $("#priority").val(),
                //     from_date: $("#from_date").val(),
                //     to_date: $("#to_date").val(),
                // }
                showTickeReport();
            });
            $('#btn-export').on('click',function(){
                let query = {
                    status: $("#status").val(),
                    priority: $("#priority").val(),
                    from_date: $("#from_date").val(),
                    to_date: $("#to_date").val()
                };
                var url = "{{URL::to('admin/ticket/report/export')}}?" + $.param(query)
                window.location = url;
            });
        });

        function showTickeReport(){
            $.ajax({
                type: "POST",
                url: "{{url('admin/ticket/report/search')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: $("#status").val(),
                    priority: $("#priority").val(),
                    from_date: $("#from_date").val(),
                    to_date: $("#to_date").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    var rows = response.success;
                    var tr = "";
                    if (rows.length > 0) {
                        $(rows).each(function(index, row) {
                            let created_at = moment(row.created_at).format('D-MMM-YYYY');
                            let updated_at = moment(row.updated_at).format('D-MMM-YYYY');
                            let due_date = row.due_date ? moment(row.due_date).format('D-MMM-YYYY') : "";
                            let assign_by = row.assignedTo;
                            let dt = moment(row.dt).format('D-MMM-YYYY');
                            let ticket_type = "Normal";
                            if (row.ticket_type == 1) {
                                ticket_type = "Specail Case";
                            }
                            tr += '<tr class="odd">'+
                                '<td><a href="{{url("admin/ticket/detail")}}/'+(row.id)+'">'+(row.trackid)+'</a></td>'+
                                    '<td><a href="{{url("admin/ticket/detail")}}/'+(row.id)+'">'+(dt)+'</a></td>'+
                                    '<td>'+(row.from_department ? row.from_department.name_english : "")+(row.branch ? row.branch.branch_name_en : "")+'</td>'+
                                    '<td>'+row.name+'</td>'+
                                    '<td>'+(row.department ? row.department.name_english: "")+'</td>'+
                                    '<td class="sub-issue-type sub-message" data-assign-by="'+(assign_by)+'" data-message="'+(row.message)+'">'+
                                        '<a href="javascript:void(0)">'+row.subject+'</a>'+
                                    '</td>'+
                                    '<td style="color: '+row.custom_status.color+'">'+row.custom_status.name+'</td>'+
                                    '<td >'+(ticket_type)+'</td>'+
                                    '<td class="sub-issue-type" data-toggle="tooltip" data-html="true" title="">'+(row.custom1)+'</td>'+
                                    // '<td class="sub-issue-type" data-toggle="tooltip" data-html="true" title="'+(row.issue_type ? row.issue_type.name : "")+'">'+(row.issue_type ? row.issue_type.name : "")+'</td>'+
                                    '<td>'+
                                        '<div style="display: flex">'+
                                            '<i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>'+(row.priority)+'</span>'+
                                            // '<i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:'+row.priorities.color+'"></i> <span>'+(row.priority ? row.priorities.name : "")+'</span>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+(row.assigned_to ? row.assigned_to.name : row.assignedTo)+'</td>'+
                                    '<td>'+(row.last_replier ? row.last_replier.name : row.name)+'</td>'+
                                    '<td>'+due_date+'</td>'+
                                    '<td>'+updated_at+'</td>'+
                            '</tr>';
                        });
                    } else {
                        var tr ='<tr><td colspan=11 align="center">No data available in table</td></tr>';
                    }
                    $("#dt-basic-ticket-report tbody").html(tr);
                    $('#dt-basic-ticket-report').dataTable();

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

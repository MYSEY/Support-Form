@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row filter-btn">
                        <div class="col-md-2">
                            <div class="form-group">
                                {{-- <label class="">Closed Date</label> --}}
                                <input type="text" class="form-control datepicker-ranges" name="closed_date" id="closed_date" value="" placeholder="Closed Date">
                            </div>
                        </div>
                        {{-- <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="">Date From</label>
                                <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="" placeholder="Date From">
                            </div>
                        </div> --}}
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                {{-- <label for="">Submited Date</label> --}}
                                <input type="text" class="form-control datepicker" name="submited_date" id="submited_date" value="" placeholder="Submited Date">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <select class="form-control" id="priority" data-select2-id="select2-data-2-c0n2" name="priority">
                                    <option value="">-- Select Priority --</option>
                                    @foreach ($priority as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2-placeholder-multiple form-control" multiple="" name="status" id="status" data-select2-id="multiple-placeholder" tabindex="-1" aria-hidden="true">
                                    @foreach ($status as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="user_id" id="user_id">
                                    <option value="">-- Select Users --</option>
                                    @foreach ($user as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect btn-sm waves-themed" id="btnSearch">Search</a>
                            @can('Ticket Report Export')
                                <a href="javascript:void(0)" class="btn btn-outline-success btn-sm waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                            @endcan
                            <a href="javascript:void(0)" class=""><span class="btn btn-outline-danger btn-sm btn-reset">Reset</span></a>
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
                            <table id="tbl_ticket_report" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="min-width: 100px;">Tracking ID</th>
                                        <th style="min-width: 100px;">Submitted Date</th>
                                        <th style="min-width: 150px;">From Department Branch</th>
                                        <th style="min-width: 100px;">Create By</th>
                                        <th style="min-width: 100px;">To Department</th>
                                        <th style="min-width: 100px;">Subjesct</th>
                                        <th style="min-width: 100px;">Ticket Status</th>
                                        <th style="min-width: 100px;">Ticket Type</th>
                                        <th style="min-width: 100px;">Sub Issue Type</th>
                                        <th style="min-width: 100px;">Ticket Priority</th>
                                        <th style="min-width: 100px;">Assigned</th>
                                        <th style="min-width: 100px;">Last Replier</th>
                                        <th style="min-width: 100px;">Ticket Due Date</th>
                                        <th style="min-width: 100px;">Close Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let from_date = null;
        let submited_date = null;
        let closed_date = null;
        $(document).ready(function(){
            $('#btnSearch').on('click', function() {
                from_date = $('#from_date').val();
                submited_date = $('#submited_date').val();
                closed_date = $('#closed_date').val();
                let priority = $('select[name="priority"]').val();
                let status = $('select[name="status"]').val();
                let user_id = $('select[name="user_id"]').val();
                $('#tbl_ticket_report').DataTable().ajax.reload();
            });

            $('.btn-reset').on('click', function() {
                $('#closed_date').val('');
                $('#submited_date').val('');
            });

            dataTables();

            $('#btn-export').on('click',function(){
                let query = {
                    user_id: $("#user_id").val(),
                    status: $("#status").val(),
                    priority: $("#priority").val(),
                    from_date: $("#from_date").val(),
                    submited_date: $("#submited_date").val(),
                    closed_date: $("#closed_date").val()
                };
                var url = "{{URL::to('admin/ticket/report/export')}}?" + $.param(query)
                window.location = url;
            });

            $(document).on('mouseenter', '.sub-message', function() {
                function removeBrTags(input) {
                    return input.replace(/<br\s*\/?>/gi, '');
                }
                var assignBy = $(this).data('assign-by');
                var message = $(this).data('message');
                var cleanedMessage = removeBrTags(message);
                var tooltipContent = assignBy + ' » ' + cleanedMessage;
                $(this).attr('data-toggle:','tooltip').attr('data-html', 'true').attr('title', tooltipContent);
            });

            $('.sub-issue-type').each(function() {
                var text = $(this).text();
                var limit = 20; // Set your character limit
                if (text.length > limit) {
                    var truncated = text.substring(0, limit) + '...';
                    $(this).text(truncated);
                }
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
        function dataTables() {
            $('#tbl_ticket_report').DataTable({
                // dom: 'Blfrtip',
                pageLength: 10,
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: {
                    url: '{{ URL("admin/report/ticket") }}',
                    type: 'GET',
                    data: function(d) {
                        d.from_date = from_date;
                        d.submited_date = submited_date;
                        d.closed_date = closed_date;
                        d.priority = $('select[name="priority"]').val();
                        d.status = $('select[name="status"]').val();
                        d.user_id = $('select[name="user_id"]').val();
                    }
                },
                columns: [
                    {
                        data: 'trackid',
                        name: 'trackid',
                        render: function(data, type, row) {
                            return `<a href="{{url("admin/ticket/detail")}}/${row.id}">${row.trackid}</a></td>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'dt',
                        name: 'dt',
                        render: function(data, type, row) {
                            return `<a href="{{url("admin/ticket/detail")}}/${row.id}">${moment(row.dt).format('D-MMM-YYYY')}</a></td>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_english',
                        name: 'name_english',
                        render: function(data, type, row) {
                            return row.name_english  ? row.name_english : row.branch_name_en
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'name_english',
                        name: 'name_english'
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                        render: function(data, type, row) {
                            const truncatedSubject = row.subject.length > 20 ? row.subject.substring(0, 20) + '...' : row.subject;
                            return `<div class="sub-issue-type sub-message" data-assign-by="${row.assign_by}" data-message="${row.message}">
                                    <a href="#">
                                        ${truncatedSubject}
                                    </a>
                                </div>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status_name',
                        name: 'status_name',
                        render: function(data, type, row) {
                            const iconColor = row.color || '#000';
                            return `<span style="color: ${iconColor};">${data}</span>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ticket_type',
                        name: 'ticket_type',
                        render: function(data, type, row) {
                            return row.ticket_type == 1 ? "Specail Case" : "Normal"
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'issue_type_name',
                        name: 'issue_type_name',
                        render: function(data, type, row) {
                            const issueTypeName = row.issue_type_name || '';
                            const issue_type = issueTypeName.length > 20  ? issueTypeName.substring(0, 20) + '...' : issueTypeName;
                            return `<span title="${issueTypeName}">${issue_type}</span>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'prioritie_name',
                        name: 'prioritie_name',
                        render: function(data, type, row) {
                            const colorStyle = row.priority_color;
                            return `<i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:${colorStyle}"></i> <span>${row.prioritie_name}</span>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'owner_name',
                        name: 'owner_name',
                    },
                    {
                        data: 'lastreplier',
                        name: 'lastreplier'
                    },
                    {
                        data: 'due_date',
                        name: 'due_date',
                        render: function(data, type, row) {
                            return row.due_date ? `${moment(row.due_date).format('D-MMM-YYYY')}` : "";
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    }
                ],
                order: [[0, 'desc']]
            });
        }
    </script>
@endsection

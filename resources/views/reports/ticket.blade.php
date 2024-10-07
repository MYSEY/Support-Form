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
                            <table id="dt-basic-ticket-report" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Tranking ID</th>
                                        <th>Subject</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Submited Date</th>
                                        <th>Department</th>
                                        <th>Priority</th>
                                        <th>Owner</th>
                                        <th>Issue Type</th>
                                        <th>Status</th>
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
                            let dt = moment(row.dt).format('D-MMM-YYYY')
                            tr += '<tr class="odd">'+
                                '<td>'+ row.trackid +'</td>'+
                                '<td>'+ row.subject +'</td>'+
                                '<td>'+ row.name +'</td>'+
                                '<td>'+ row.email +'</td>'+
                                '<td>'+ row.dt +'</td>'+
                                '<td>'+ row.category +'</td>'+
                                '<td>'+row.priority+'</td>'+
                                // '<td style="color:'+row.priorities.color+'">'+row.priorities.name+'</td>'+
                                '<td>'+ (row.assigned_by ? row.assigned_by.name: "") +'</td>'+
                                '<td>'+ row.custom1 +'</td>'+
                                // '<td>'+ row.issue_type +'</td>'+
                                '<td>'+ row.status +'</td>'+
                                // '<td style="color:'+row.custom_status.color+'">'+ row.custom_status.name +'</td>'+
                            '</tr>';
                        });
                    } else {
                        var tr ='<tr><td colspan=11 align="center">No data available in table</td></tr>';
                    }
                    $("#dt-basic-ticket-report tbody").html(tr);
                    $('#dt-basic-ticket-report').dataTable();
                }
            });
        }
    </script>
@endsection

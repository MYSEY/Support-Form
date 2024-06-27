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
                        <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <select class="select form-control" id="priority" data-select2-id="select2-data-2-c0n2" name="priority">
                                    <option value="">-- Select Priority --</option>
                                    <option value="1">High</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Low</option>
                                    <option value="0">Critical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group" data-select2-id="105">
                                <select class="select2-placeholder-multiple form-control select2-hidden-accessible"
                                    multiple="" id="multiple-placeholder" data-select2-id="multiple-placeholder"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="0">Open</option>
                                    <option value="1">Waition Replay</option>
                                    <option value="2">Replied</option>
                                    <option value="4">In Progress</option>
                                    <option value="5">On Hold</option>
                                    <option value="6">Fixed</option>
                                    <option value="3">Resolved</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="text-align: right;">
                            <a href="javascript:void(0)" class="btn btn-outline-success waves-effect waves-themed" id="btnSearch">Search</a>
                            {{-- <a href="#" title="Export" data-filter-tags="datatables datagrid export tables pdf excel print csv">
                                <span class="nav-link-text" data-i18n="nav.datatables_export">Export</span>
                            </a> --}}
                            <button class="btn btn-outline-success waves-effect waves-themed mr-1" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></button>
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
                        <!-- datatable start -->
                        <table id="dt-basic-report-ticke" class="table table-bordered table-hover table-striped w-100">
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
                                {{-- @if (count($data) > 0)
                                    @foreach ($data as $key => $item)
                                        <tr class="">
                                            <th><a href="#">{{ $item->trackid }}</a></th>
                                            <th>{{ $item->subject }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ Carbon\Carbon::parse($item->dt)->format('d-m-Y') }}</td>
                                            <td>{{ $item->name_khmer }}</td>
                                            <td>{{ $item->priorities_name }}</td>
                                            <td>{{ $item->owner }}</td>
                                            <td>{{ $item->custom2 == '' ? $item->custom1 : $item->custom2 }}</td>
                                            <td>{{ $item->status }}</td>
                                        </tr>
                                    @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('includs.datatables_export')
    <script>
        $(document).ready(function(){
            showTickeReport();
            $("#btnSearch").on("click", function() {
                // $("#dt-basic-report-ticke tbody").empty();
                // let param = {
                //     "_token": "{{ csrf_token() }}",
                //     status: $("#status").val(),
                //     priority: $("#priority").val(),
                //     from_date: $("#from_date").val(),
                //     to_date: $("#to_date").val(),
                // }
                showTickeReport();
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
                            if (row.status == 0) {
                                var status = 'Open';
                            } else if(row.status == 1) {
                                var status = 'Waition Replay';
                            }else if(row.status == 2){
                                var status = 'Replied';
                            }else if(row.status == 3){
                                var status = 'Resolved';
                            }else if(row.status == 4){
                                var status = 'In Progress';
                            }else if(row.status == 5){
                                var status = 'On Hold';
                            }else if(row.status == 6){
                                var status = 'Fixed';
                            }
                            if (row.priority == 1) {
                                var priority = 'High';
                            } else if(row.priority == 2) {
                                var priority = 'Medium';
                            }else if(row.priority == 3){
                                var priority = 'Low';
                            }else{
                                var priority = 'Critical';
                            }
                            
                            tr += '<tr class="odd">'+
                                '<td>'+ row.trackid +'</td>'+
                                '<td>'+ row.subject +'</td>'+
                                '<td>'+ row.name +'</td>'+
                                '<td>'+ row.email +'</td>'+
                                '<td>'+ dt +'</td>'+
                                '<td>'+ row.cate_name +'</td>'+
                                '<td>'+ priority +'</td>'+
                                '<td>'+ row.owner_name +'</td>'+
                                '<td>'+ row.custom1 +'</td>'+
                                '<td>'+ status +'</td>'+
                            '</tr>';
                        });
                    } else {
                        var tr ='<tr><td colspan=11 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $("#dt-basic-report-ticke tbody").html(tr);
                    $('#dt-basic-report-ticke').dataTable();
                }
            });
        }
    </script>
@endsection

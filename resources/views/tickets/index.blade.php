@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Ticket List
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>Tracking ID</th>
                                <th>Submitted</th>
                                <th>Updated</th>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Subjesct</th>
                                <th>Status</th>
                                <th>Owner</th>
                                <th>Last Replier</th>
                                <th>Due Date</th>
                                <th>Sub Issue Type</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                                <td>$320,800</td>
                            </tr>
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
    @include('includs.datatable_basic')
@endsection

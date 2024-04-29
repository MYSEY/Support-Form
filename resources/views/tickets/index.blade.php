@extends('layouts.admin')
@section('content')
<div class="demo">
    <a type="button" id="btn-crearte" href="{{url('admin/ticket/create')}}" class="btn btn-danger waves-effect waves-themed float-right">Create New Ticket</a>
</div>
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" data-permiss="1" href="#js_change_pill_direction-1">Open tickets</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" data-permiss="2" href="#js_change_pill_direction-2">Assigned to me</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" data-permiss="3" href="#js_change_pill_direction-3">Assigned to others</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" data-permiss="4" href="#js_change_pill_direction-4">Unassigned</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" data-permiss="5" href="#js_change_pill_direction-5">Due soon</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" data-permiss="6" href="#js_change_pill_direction-6">Overdue</a></li>
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
                    <div class="tab-content py-3">
                        @include('tickets.table-tickets')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dt-basic-assign').DataTable();
            $('#dt-basic-assign-other').DataTable();
            $('#dt-basic-unassigned').DataTable();
            $('#dt-basic-due-soon').DataTable();
            $('#dt-basic-overdue').DataTable();
        });  
    </script>
@endsection


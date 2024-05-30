@extends('layouts.admin')
@section('content')
<div class="demo">
    {{-- href="{{url('admin/ticket/create')}}" --}}
    <a type="button" id="btn-crearte" href="#" data-toggle="modal" data-target="#modal-select" class="btn btn-danger waves-effect waves-themed float-right">Create New Ticket</a>
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
<div class="modal fade show" id="modal-select" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please select Department or Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if (count($department)>0)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Department</label>
                                <div class="dropdown-menu d-block position-relative float-none">
                                    @foreach ($department as $item)
                                        <a class="dropdown-item" href="{{url('admin/ticket/create','department'.$item->id)}}">
                                            <span class="float-right"><i class="fal fa-angle-right" style="font-size: 20px"></i></span>{{$item->name_english}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (count($branch)>0)
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
                    @endif
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


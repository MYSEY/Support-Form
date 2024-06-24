@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <form novalidate>
            @csrf
            <div class="row filter-btn">
                <div class="col-sm-2 col-md-2"> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="Tracking ID" value="">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2"> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="from_date" id="" value="" placeholder="From Date">
                    </div>
                </div>
                
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="to_date" id="" value="" placeholder="To Date">
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
                <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                    <div class="form-group" data-select2-id="105">
                        <select class="select2-placeholder-multiple form-control select2-hidden-accessible" multiple="" id="multiple-placeholder" data-select2-id="multiple-placeholder" tabindex="-1" aria-hidden="true">
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
            </div>
        </form>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                   Ticket Report
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    {{-- <div class="table-responsive"> --}}
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                @if (count($data)>0)
                                    @foreach ($data as $key=>$item)
                                        <tr class="odd">
                                            <th class="sorting_1">{{$key + 1}}</th>
                                            <th><a href="#">{{$item->trackid }}</a></th>
                                            <th>{{$item->subject }}</th>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->dt}}</td>
                                            <td>{{$item->name_khmer}}</td>
                                            <td>{{$item->priorities_name}}</td>
                                            <td>{{$item->owner}}</td>
                                            <td>{{$item->custom2 == '' ? $item->custom1 : $item->custom2}}</td>
                                            <td>{{$item->status}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    
@endsection
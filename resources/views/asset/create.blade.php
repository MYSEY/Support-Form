@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Asset
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <form action="{{url('admin/asset')}}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="panel-content">
                            <div class="row mb-2">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Serial">Serial</label>
                                        <input type="text" name="serial" class="form-control required" id="serial">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible" id="category_id" name="category_id" required>
                                            <option value="">-- Select --</option>
                                            @foreach ($cateagory as $item)
                                                <option value="{{$item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Device Name">Device Name <span class="text-danger">*</span></label>
                                        <input type="text" name="device_name" class="form-control required" id="device_name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="end_user">End User</label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible" id="end_user" name="end_user" required>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $item)
                                                <option value="{{$item->id}}">{{ $item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible" id="location" name="location" required>
                                            <option value="">-- Select --</option>
                                            @foreach ($location as $item)
                                                <option value="{{$item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="office">Office <span class="text-danger">*</span></label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible" id="office" name="office" required>
                                            <option value="">-- Select --</option>
                                            @foreach ($office as $item)
                                                <option value="{{$item->id}}">{{ $item->branch_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date">date <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control required" id="date" required>
                                    </div>
                                </div>
                            </div>
            
                            <div class="text-md-right">
                                <div class="btn-hidden-show">
                                    <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/asset')}}"  type="button">Cancel</a>
                                    <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" type="submit">Submit</button>
                                </div>
                                <input type="hidden" value="{{csrf_token()}}" id="token"/>
                                <div class="btn-loading mt-3" style="display: none">
                                    <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
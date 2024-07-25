


@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container">
                <div class="panel-content">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{$role->name}}" placeholder="Role Name">
                    </div>
                    <label>Check All Permission</label>
                    <hr>

                    <div class="row">
                        @foreach ($permission as $key=>$item)
                            <div class="col-md-4 mb-2">
                                <div class="form-group">
                                    <div class="frame-wrap">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="defaultInline_{{ $key }}">
                                            <label class="custom-control-label" for="defaultInline_{{ $key }}">{{$item->name}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-sm-12 col-md-12 text-right">
                        <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" type="button">Submit</button>
                        <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/role')}}"  type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
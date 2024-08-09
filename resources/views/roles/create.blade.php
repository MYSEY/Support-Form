@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container">
                <div class="panel-content">
                    <form action="{{ url('admin/role') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <div class="frame-wrap">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" name="" id="defaultInline" value="" onClick="toggle(this)">
                                    <label class="custom-control-label" for="defaultInline">Check All Permission</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label for="">Permission Name</label>
                        <div class="row">
                            @foreach ($permission as $key=>$item)
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <div class="frame-wrap">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input check_all" name="permission[]" id="defaultInline_{{ $key }}" value="{{$item->id}}">
                                                <label class="custom-control-label" for="defaultInline_{{ $key }}">{{$item->name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>

                        <div class="text-right">
                            <button type="submit" class="btn btn-danger waves-effect waves-themed">Submit</button>
                            <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('admin/role')}}"  type="button">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function toggle(source) {
            checkboxes = $('.check_all');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection
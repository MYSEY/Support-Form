@extends('layouts.admin')
@section('content')
<div class="demo">
    <a type="button" id="btn-crearte" href="#" class="btn btn-danger waves-effect waves-themed float-right">New Ticket</a>
    <a href="{{url('admin/ticket')}}" class="btn btn-secondary waves-effect waves-themed float-right"><span>Back</span></a>
</div>
<div class="panel-content">
    <div class="card-deck justify-content-center">
        <div class="row w-100">
            @foreach ($datas as $index => $item)
                <div class="col-md-4 mb-4 p-0">
                    <div class="card border-success draggable" draggable="true">
                        <div class="card-header border-success">{{$item->title}}</div>
                        <div class="card-body">
                            {!! $item->remark !!}
                           {{$item->attachments ? "* Click to view the guide": ""}} <a href="{{url("storage/attachments")}}/{{$item->attachments}}" target="_blank">{{$item->attachments}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
        $(function(){
            $("#btn-crearte").on("click", function() {
                var url = window.location.href;
                var parts = url.split('/');
                var namURL = parts.pop() || parts.pop();
                var url = "{{ URL('admin/ticket/create/') }}/" + namURL;
                window.location.replace(url); 
            })
        });
    </script>
@endsection

@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    User access role permission
                </h2>
            </div>
            
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <a href="{{url('admin/role')}}" class="btn btn-secondary waves-effect waves-themed btn-sm mr-1"><span><i class="fal fa-backward"></i> Back</span></a>
                    </div>
                </div>
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Branch</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users)>0)
                                @foreach ($users as $key=>$item)
                                    <tr>
                                        <td >{{$key+1}}</td>
                                        <td >{{$item->name}}</td>
                                        <td>{{$item->name_english}}</td>
                                        <td>{{$item->branch_name_en}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@include('includs.datatable_basic')

    <script>
    </script>
@endsection
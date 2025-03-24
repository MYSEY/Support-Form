@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintenance 
                    </h2>
                </div>
                
                <div class="panel-container show">
                    {{-- @can('Asset Create') --}}
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1"><i class="fal fa-file"></i> Import</a>
                                <a href="{{url('admin/maintenance/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                            </div>
                        </div>
                    {{-- @endcan --}}
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Category</th>
                                        <th>DeviceName</th>
                                        <th>Office</th>
                                        <th>Location</th>
                                        <th>EndUser</th>
                                        <th>Postion</th>
                                        <th>AssetDate</th>
                                        <th>Lifecycle(Month)</th>
                                        <th>CreatedAt</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
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
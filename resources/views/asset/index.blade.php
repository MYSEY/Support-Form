@extends('layouts.admin')
@section('content')
    <style>
        .rating {
            font-size: 24px;
            color: gold; /* Default color of stars */
            display: inline-block;
        }

        .rating .star {
            cursor: pointer;
            float: left;
            font-size: 24px;
            color: #ccc; /* Default color of inactive stars */
        }

        .rating .star:hover,
        .rating .star.active {
            color: gold; /* Color of active stars */
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Asset 
                    </h2>
                </div>
                
                <div class="panel-container show">
                    {{-- @can('User Create') --}}
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a href="{{url('admin/asset/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                            </div>
                        </div>
                    {{-- @endcan --}}
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Serial</th>
                                        <th>Category</th>
                                        <th>DeviceName</th>
                                        <th>Office</th>
                                        <th>Location</th>
                                        <th>End User</th>
                                        <th>Postion</th>
                                        <th>Lifecycle (Month)</th>
                                        <th>Created At</th>
                                        <th>Action</th>
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
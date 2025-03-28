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
                                        <th>#</th>
                                        <th>MaintenanceDate</th>
                                        <th>Technician</th>
                                        <th>Serial</th>
                                        <th>Category</th>
                                        <th>DeviceName</th>
                                        <th>Office</th>
                                        <th>Location</th>
                                        <th>EndUser</th>
                                        <th>Postion</th>
                                        <th>CreatedAt</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->maintenance_date}}</td>
                                                <td>{{$item->maintenace_by}}</td>
                                                <td>{{$item->serial}}</td>
                                                <td>{{$item->category_name}}</td>
                                                <td>{{$item->device_name}}</td>
                                                <td>{{$item->branch_name_en}}</td>
                                                <td>{{$item->location}}</td>
                                                <td>{{$item->employee_name_en}}</td>
                                                <td>{{$item->name_english}}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('Category Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_maintenance" title="Delete Record" data-id="{{$item->id}}"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        @can('Category Edit')
                                                            <a href="{{url('admin/maintenance',$item->id)}}/edit" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                        @endcan
                                                        @can('Category Edit')
                                                            <a href="{{url('admin/maintenance',$item->id)}}" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" title="Detail"><i class="fal fa-eye"></i></a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Task Modal -->
    <div class="modal custom-modal fade" id="delete_maintenance" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/maintenance/delete')}}" method="POST">
                            @csrf
                            @method('Delete')
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="float-lg-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger waves-effect waves-themed">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@include('includs.datatable_basic')
    <script>
        $(function(){
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection
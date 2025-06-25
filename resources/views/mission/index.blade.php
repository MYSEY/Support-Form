@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintenance Mission
                    </h2>
                </div>
                <div class="panel-container show">
                    @can('Maintenance Mission Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#MaintenanceMissionCreate" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <div class="table-responsive">
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Data</th>
                                        <th>Description</th>
                                        <th>CreatedAt</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->date}}</td>
                                                <td>{{$item->description}}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('Task Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_maintenance_mission" title="Delete Record" data-id="{{$item->id}}"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        @can('Task Edit')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success  btn-icon btn-inline-block mr-1" id="btn_updated" data-toggle="modal" data-target="#user-edit" data-id="{{$item->id}}" title="Edit"><i class="fal fa-edit"></i></a>
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
    <!-- Delete Branch Modal -->
    <div class="modal custom-modal fade" id="delete_maintenance_mission" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/mission/delete')}}" method="POST">
                            @csrf
                            @method('Delete')
                            <input type="hidden" name="id" class="e_id" id="e_id" value="">
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
    @include('mission.import')
    @include('mission.create')
    @include('mission.edit')
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script>
        $(function(){
            $(document).on('click','#btn_updated',function(){
                let id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: `{{ url('/admin/mission/${id}') }}`,
                    dataType: "JSON",
                    success: function (response) {    
                        if (response.success) {
                            $('#id').val(response.success.id);
                            $('#name').val(response.success.name);
                            $('#date').val(response.success.date);
                            $('#description').val(response.success.description);
                            $('#maintananceMissionEdit').modal('show');
                        }
                    }
                });
            });
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection
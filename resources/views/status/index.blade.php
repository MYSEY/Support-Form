@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Statuses
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#status-create" type="button"><span><i class="fal fa-plus mr-1"></i> Add New</span></button>
                    </div>
                </div>
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>CSS Class or Color</th>
                                <th>Tickets</th>
                                <th>Changeable by Employee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="color" style="color: {{$item->color}}">{{$item->name}}</td>
                                        <td class="order">{{$item->order}}</td>
                                        <td class="can_customers_change">{{$item->can_customers_change}}</td>
                                        <td>
                                            <div class="d-flex demo">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 status-delete" data-toggle="modal" data-target="#delete_status" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 update" data-toggle="modal" data-id="{{$item->id}}" data-color="{{$item->color}}" data-target="#status-edit" title="Edit"><i class="fal fa-edit"></i></a>
                                            </div>
                                        </td>
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

<!-- Modal Create New Status -->
<div class="modal fade" id="status-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Statuses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/statuses/store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color preview on text</label>
                        <input type="color" class="form-control" name="color">
                    </div>
                    <div class="form-group">
                        <div class="frame-wrap">
                            <div class="demo">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="can_customers_change" name="can_customers_change">
                                    <label class="custom-control-label" for="can_customers_change">Can customers change this status?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="status-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/statuses/update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" class="e_id" value="">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" id="e_name" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color preview on text</label>
                        <input type="color" class="form-control" id="e_color" name="color">
                    </div>
                    <div class="form-group">
                        <div class="frame-wrap demo">
                            <div class="demo">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="e_can_customers_change" name="can_customers_change">
                                    <label class="custom-control-label" for="e_can_customers_change">Can customers change this status?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- Delete Department Modal -->
 <div class="modal custom-modal fade" id="delete_status" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/statuses/delete')}}" method="POST">
                        @csrf
                        <input type="hidden"  name="id" class="e_id" value="">
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
            $("#e_can_customers_change, #can_customers_change").on("click", function () {
                if (!$(this).prop("checked")) {
                    $(this).prop("checked", false);
                    $(this).val(0)
                }
                if ($(this).prop("checked")) {
                    $(this).prop("checked", true);
                    $(this).val(1)
                }
            });
            $(document).on('click','.update', function(){
                var _this = $(this).parents('tr');
                let id = $(this).data("id");
                let color = $(this).data("color");
                $('.e_id').val(id);
                $('#e_name').val(_this.find('.name').text());
                $('#e_color').val(color);
                if (_this.find('.can_customers_change').text() == 0) {
                    $('#e_can_customers_change').prop("checked", false);
                    $('#e_can_customers_change').val(0)
                }else{
                    $('#e_can_customers_change').prop("checked", true);
                    $('#e_can_customers_change').val(1)
                }
            });

            $(document).on('click','.status-delete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
    </script>
@endsection

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
                    @can('Asset Create')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a type="button" id="btn-import" href="#" data-toggle="modal" data-target="#modal-import" class="btn btn-danger btn-sm mr-1"><i class="fal fa-file"></i> Import</a>
                                <a href="{{url('admin/asset/create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
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
                                        <th width="100%">Serial</th>
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
                                    @if (count($data)>0)
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->serial}}</td>
                                                <td>{{$item->CategoryName}}</td>
                                                <td>{{$item->device_name}}</td>
                                                <td>{{$item->OfficeName}}</td>
                                                <td>{{$item->RoomName}}</td>
                                                <td>{{ $item->employee_name_en}}</td>
                                                <td>{{$item->name_english}}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{$item->LifecycleMonthDiff}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('Asset Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#btnDeleteAsset" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        @can('Asset Edit')
                                                            <a href="{{url('admin/asset/'.$item->id)}}/edit" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit" data-id="{{$item->id}}"><i class="fal fa-edit"></i></a>
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
    <div class="modal custom-modal fade" id="btnDeleteAsset" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/asset/delete')}}" method="POST">
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
    @include('asset.import')
@endsection

@section('script')
@include('includs.datatable_basic')
    <script>
        var edit = @json(Auth::user()->can('Task Edit'));
        var Taskdelete = @json(Auth::user()->can('Task Delete'));
        $(function(){
            // dataTables();
            $(".upload_file_data").on("click", function() {
                if ($('#result_file').val() == "") {
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css("color", "red");
                    $(".thanLess").show();
                    return false;
                }
                var file_data = $('#result_file').prop('files')[0];
                var fileName = file_data['name'];
                var form_data = new FormData();
                var fileExtension = fileName.split('.').pop();
                var fileSize = file_data['size'];
                form_data.append('file', file_data);
                form_data.append('_token', "{{ csrf_token() }}");
                if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {

                    $(".upload_file_data").prop('disabled', true);
                    $(".btn-hidden-show").hide();
                    $(".btn-impot-loading").css('display', 'block');

                    $("#modal-import").modal("show");
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/asset/import') }}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.mg == 'success') {
                                $("#modal-import").modal("hide");
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('admin/asset') }}");
                            }
                        },error: function(xhr, status, error) {
                            // Display error message if AJAX request fails
                            Swal.fire("Error!", "An error occurred while processing your request. Please try again.","error");
                        },
                    });
                }else{
                    $("#thanLess").text("Please select a xls,xlsx and csv file and size less then 1MB").css("color", "red");
                    $(".thanLess").show();
                }
            });
            $(document).on('click','.btnDelete', function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
        });
        // function dataTables() {
        //     $('#dt-basic-example').DataTable({
        //         // dom: 'Blfrtip',
        //         pageLength: 10,
        //         destroy: true,
        //         processing: true,
        //         serverSide: true,
        //         order: [[0, 'desc']],
        //         lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        //         ajax: {
        //             url: '{{ URL("admin/asset") }}',
        //             type: 'GET'
        //         },
        //         columns: [
        //             {
        //                 data: 'serial',
        //                 name: 'serial',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'cate_name',
        //                 name: 'cate_name',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'device_name',
        //                 name: 'device_name',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'office',
        //                 name: 'office',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'location',
        //                 name: 'location',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'end_user',
        //                 name: 'end_user',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'end_user',
        //                 name: 'end_user',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'date',
        //                 name: 'date',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'lifecycle_month',
        //                 name: 'lifecycle_month',
        //                 orderable: true
        //             },
        //             {
        //                 data: 'created_at',
        //                 name: 'created_at',
        //                 orderable: true
        //             },
        //             {
        //                 data: '',
        //                 name: 'action',
        //                 render: function(data, type, row) {
        //                     let buttons = '';
        //                     if (row.id) {
        //                         if (edit) {
        //                             buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-success btn-icon btn-inline-block mr-1" id="btn_updated" data-toggle="modal" data-target="#user-edit" data-id="${row.id}" title="Edit"><i class="fal fa-edit"></i></a>`;
        //                         }
        //                         if (Taskdelete) {
        //                             buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 btnDelete" data-toggle="modal" data-target="#delete_task" title="Delete Record" data-id="${row.id}"><i class="fal fa-times"></i></a>`;
        //                         }
        //                     }
        //                     return buttons || '';
        //                 },
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ],
        //         order: [[0, 'desc']]
        //     });
        // }
    </script>
@endsection
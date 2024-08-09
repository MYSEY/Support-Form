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
                        User List
                    </h2>
                </div>
                
                <div class="panel-container show">
                    @can('create user')
                        <div class="panel-tag">
                            <div class="text-lg-right">
                                <a href="{{url('admin/user/form-create')}}" class="btn btn-success btn-sm mr-1"><span><i class="fal fa-plus mr-1"></i> Add New</span></a>
                            </div>
                        </div>
                    @endcan
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Name</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Branch</th>
                                    <th>Rating</th>
                                    <th>Auto Asign</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data)>0)
                                    @foreach ($data as $key=>$item)
                                        <tr>
                                            <td class="sorting_1" tabindex="0">
                                                <img src="{{asset('admins/img/demo/avatars/avatar-m.png')}}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 36px;height: 36px;">
                                            </td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->user}}</td>
                                            <td>{{$item->role_name}}</td>
                                            <td>{{$item->name_english}}</td>
                                            <td>{{$item->branch_name_en}}</td>
                                            <td style="text-align:center">
                                                <div class="rating" data-rating="{{$item->rating}}"></div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="frame-wrap demo">
                                                    <div class="demo">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                {{$item->autoassign == "1" ? "checked": ""}}
                                                                value="{{$item->autoassign}}"
                                                            >
                                                            <label class="custom-control-label"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex demo">
                                                    @can('User Delete')
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1 status-delete" data-toggle="modal" data-target="#delete_user" data-id="{{$item->id}}" title="Delete Record"><i class="fal fa-times"></i></a>
                                                    @endcan    
                                                    @can('User Edit')
                                                        <a href="{{url("admin/user/form-edit")}}/{{$item->id}}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1 show-data-edit" title="Edit"><i class="fal fa-edit"></i></a>
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

    <!-- Delete User Modal -->
    <div class="modal custom-modal fade" id="delete_user" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h5 class="modal-title">Delete</h5>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('admin/user/delete')}}" method="POST">
                            @csrf
                            <input type=""  name="id" class="e_id" value="">
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
        document.addEventListener("DOMContentLoaded", function() {
            var ratings = document.querySelectorAll('.rating');
            ratings.forEach(function(rating) {
                var stars = '';
                var ratingValue = parseFloat(rating.getAttribute('data-rating'));
                for (var i = 1; i <= 5; i++) {
                    if (i <= ratingValue) {
                        stars += '<span class="star active">&#9733;</span>';
                    } else if (i - ratingValue < 1) {
                        stars += '<span class="star active">&#9734;</span>';
                    } else {
                        stars += '<span class="star">&#9734;</span>';
                    }
                }
                rating.innerHTML = stars;
            });
        });
        $(document).on('click','.status-delete', function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    </script>
@endsection
@extends('layouts.admin')
@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class="subheader-icon fal fa-plus-circle"></i> Profile
        <small>
            Profile layout
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
        <!-- profile summary -->
        <div class="card mb-g rounded-top">
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        @if ($data->profile)
                            <img src="{{asset('storage/users/profile/'.$data->profile)}}" class="rounded-circle shadow-2 img-thumbnail" alt="{{$data->name}}" style="width: 160px; height:160px; object-fit: cover;">
                        @else
                            <img src="{{asset('admins/img/demo/avatars/avatar-m.png')}}" class="rounded-circle shadow-2 img-thumbnail" alt="">
                        @endif

                        <h5 class="mb-0 fw-700 text-center mt-3">
                            {{$data->name}}
                            <small class="text-muted mb-0">{{$data->RoleName}}, {{$data->DepartmentName}}</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
        <div class="card border mb-g">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="user">Real Name <span class="text-danger">*</span></label>
                            <input type="text" id="user" name="user" class="form-control @error('user') is-invalid @enderror" value="{{$data->name}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="name">Username <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$data->user}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$data->email}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="department_id">Department <span class="text-danger">*</span></label>
                            <input type="text" id="department_id" name="department_id" class="form-control @error('department_id') is-invalid @enderror" value="{{$data->DepartmentName}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch <span class="text-danger">*</span></label>
                            <input type="text" id="branch_id" name="branch_id" class="form-control @error('branch_id') is-invalid @enderror" value="{{$data->BranchName}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="role_id">Role Permission <span class="text-danger">*</span></label>
                            <input type="text" id="role_id" name="role_id" class="form-control @error('role_id') is-invalid @enderror" value="{{$data->RoleName}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Profile</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="profile" id="profile">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12" style="text-align: right;">
                        <input type="hidden" value="{{csrf_token()}}" id="token">
                        <input type="hidden" name="id" id="id" class="" value="{{$data->id}}">
                        <input type="hidden" name="old_profile" id="old_profile" value="{{$data->profile}}">
                        <a href="{{url('admin/user')}}" class="btn btn-secondary waves-effect waves-themed"><span>Back</span></a>
                        <button type="submit" id="btnUpdate" class="btn btn-primary waves-effect waves-themed">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-3">
        <!-- rating -->
        <div class="card mb-g">
            <div class="row row-grid no-gutters">
                <div class="col-12">
                    <div class="p-3">
                        <h2 class="mb-0 fs-xl">
                            {{$data->name}} Lantern's Rating
                        </h2>
                    </div>
                </div>
                <div class="col-12">
                    @foreach ($ticketStatus as $item)
                        @php
                            $statusTickets = $ticket->where('status', $item->id)->count();
                            $percentage = $statusTickets / 100;
                        @endphp
                        <div class="p-3">
                            <div class="row fs-b fw-300">
                                <div class="col text-left">
                                    {{$item->name}}
                                </div>
                                <div class="col text-right">
                                    {{ round($percentage, 2) }}% / {{ count($ticket) }}
                                </div>
                            </div>
                            <div class="progress progress-xs mt-2">
                                <div class="progress-bar" style="background-color: {{$item->color}};width: {{$percentage}};" role="progressbar"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function(){
            $("#btnUpdate").on('click',function(e){
                e.preventDefault();
                var formData = new FormData();
                var token = $("#token").val();
                var id = $("#id").val();
                var old_profile = $("#old_profile").val();
                var profile = $("#profile").prop('files')[0];
                
                formData.append('_token', token);
                formData.append('id', id);
                formData.append('old_profile', old_profile);
                formData.append('profile', profile);

                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/user/profile/update') }}",
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == "error") {
                            toastr.error(response.message);
                        }else{
                            toastr.success(response.message);
                            window.location.reload(); 
                        }
                    }
                });
            });
        });
    </script>
@endsection
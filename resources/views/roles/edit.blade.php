


@extends('layouts.admin')
<style>
    .draggable {
        cursor: move;
    }
</style>
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container">
                <form action="{{ url('admin/role',$role->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{$role->name}}" placeholder="Role Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Role Type</label>
                                    <select class="form-control @error('role_type') is-invalid @enderror" id="role_type" name="role_type">
                                        <option value="">-- Select --</option>
                                        <option value="super_admin" {{$role->role_type=='super_admin' ? 'selected' : ''}}>Super Admin</option>
                                        <option value="admin" {{$role->role_type=='admin' ? 'selected' : ''}}>Administrator</option>
                                        <option value="admin_support" {{$role->role_type=='admin_support' ? 'selected' : ''}}>Admin Support</option>
                                        <option value="staff" {{$role->role_type=='staff' ? 'selected' : ''}}>Staff</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="frame-wrap">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" name="" id="defaultInline" value="" onClick="toggle(this)">
                                    <label class="custom-control-label" for="defaultInline">Check All Permission</label>
                                </div>
                            </div>
                        </div>
                        <label for="">Permission Name</label>
                        <div class="row">
                            @foreach ($permissionCategory as $cate)
                                <?php
                                    $permission = \Spatie\Permission\Models\Permission::where('permission_category_id', $cate->id)->get();
                                ?>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <div class="card border-success draggable" draggable="true">
                                            <div class="card-header border-success">{{$cate->name}}</div>
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input check_all" id="checkAll_{{$cate->id}}" onClick="toggle_{{ $cate->id }}(this)">
                                                        <label class="custom-control-label" for="checkAll_{{$cate->id}}">Check All</label>
                                                    </div>
                                                </div>
                                                @foreach ($permission as $item)
                                                    <div class="mb-1">
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" name="permission[]" class="custom-control-input check_all ch_all_{{ $cate->id }}" id="defaultInline_{{ $item->id }}" value="{{ $item->id }}" {{ in_array($item->id, $rolePermission) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="defaultInline_{{ $item->id }}">{{$item->name}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    // checked all select
                                    function toggle_{{ $cate->id }}(source) {
                                        checkboxes = $('.ch_all_{{ $cate->id }}');
                                        for (var i = 0, n = checkboxes.length; i < n; i++) {
                                            checkboxes[i].checked = source.checked;
                                        }
                                    }
                                    // checked all select
                                </script>
                            @endforeach
                        </div>
                        <hr>
                        <div class="text-right">
                            <button class="btn btn-danger waves-effect waves-themed" type="submit">Submit</button>
                            <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('admin/role')}}"  type="button">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
         $(document).ready(function() {
            // JavaScript for drag-and-drop functionality
            const draggables = document.querySelectorAll('.draggable');
            const containers = document.querySelectorAll('.col-md-3');

            draggables.forEach(draggable => {
                draggable.addEventListener('dragstart', () => {
                    draggable.classList.add('dragging');
                });

                draggable.addEventListener('dragend', () => {
                    draggable.classList.remove('dragging');
                });
            });

            containers.forEach(container => {
                container.addEventListener('dragover', e => {
                    e.preventDefault();
                    const draggingElement = document.querySelector('.dragging');
                    container.appendChild(draggingElement);
                });
            });
        });
        function toggle(source) {
            checkboxes = $('.check_all');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection
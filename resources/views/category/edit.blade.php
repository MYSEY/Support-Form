 <!-- Modal Create Task -->
 <div class="modal fade" id="CategoryEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/category/update')}}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" id="e_name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="task">Task</label>
                        <select class="custom-select form-control" id="e_task_id" name="task_id" required>
                            <option value="">-- Select --</option>
                            @foreach ($task as $item)
                                <option value="{{$item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="float-lg-right">
                        <input type="hidden" value="" name="id" id="e_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
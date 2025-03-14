 <!-- Modal Create Category -->
 <div class="modal fade" id="CategoryEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                        <label class="form-label" for="task">Task <span class="text-danger">*</span></label>
                        <select class="select2 form-control w-100 select2-hidden-accessible e_task" name="task[]" id="e_task" multiple>
                            <option value="">-- Select --</option>
                            @foreach ($task as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="float-lg-right">
                        <input type="hidden" value="" name="category_id" id="e_category_id">
                        <input type="hidden" value="" name="task_id" id="e_task_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
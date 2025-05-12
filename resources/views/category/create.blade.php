 <!-- Modal Create Category -->
 <div class="modal fade" id="CategoryCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/category')}}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="task">Task <span class="text-danger">*</span></label>
                        <select class="select2 form-control w-100 select2-hidden-accessible" name="task[]" id="createTask" multiple>
                            <option value="">-- Select --</option>
                            @foreach ($task as $item)
                                <option value="{{$item->id}}">{{$item->name}} ({{$item->type}})</option>
                            @endforeach
                        </select>
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
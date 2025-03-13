<!-- Modal Create Task -->
<div class="modal fade" id="modalTaskEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/task/update')}}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="e_name" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="custom-select form-control" id="e_type" name="type" required>
                            <option value="">-- Select --</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="e_description" rows="6" maxlength="1000"></textarea>
                    </div>
                    <div class="float-lg-right">
                        <input type="hidden" id="e_id" name="id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
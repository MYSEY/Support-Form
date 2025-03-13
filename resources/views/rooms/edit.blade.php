<!-- Modal Create Room -->
<div class="modal fade" id="roomEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/room/update')}}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="e_name" required>
                    </div>
                    <input type="hidden" name="id" id="e_room_id">
                    <div class="float-lg-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
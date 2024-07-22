<!-- Modal Edit Note -->
<div class="modal fade" id="editNote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/note/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id" class="e_id_note" id="e_id_note" value="">
                    <div class="form-group">
                        <label class="form-label">Message: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="e_message_note" name="message" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" id="e_attachments" name="attachments" class="form-control-file">
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

<!-- Delete note Modal -->
<div class="modal custom-modal fade" id="delteNote" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/note/delete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" class="d_id_note" id="d_id_note" value="">
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
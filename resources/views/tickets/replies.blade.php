<!-- Modal Edit Reply Ticket -->
<div class="modal fade" id="editReplyTicket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Reply Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/replies/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation form-edit-reply" novalidate>
                    @csrf
                    <input type="hidden" name="id" class="e_id_reply" id="e_id_reply" value="">
                    {{-- <div class="form-group">
                        <label class="form-label">Message: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="e_message_reply" name="message" rows="5"></textarea>
                    </div> --}}
                    <div class="form-group">
                        <label class="form-label" for="eticket-assigned">Description <span class="text-danger">*</span></label>
                        <div class="js-summernote saveToLocal" id="e_ticket-reply"></div>
                        <input type="hidden" name="message" id="e_reply_message">
                    </div>
                    <div class="form-group">
                        <input type="file" id="e_attachments_reply" name="attachments" class="form-control-file">
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

<!-- Delete reply Modal -->
<div class="modal custom-modal fade" id="delteReply" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h5 class="modal-title">Delete</h5>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('admin/replies/delete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" class="d_id_reply" id="d_id_reply" value="">
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
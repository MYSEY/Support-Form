{{-- import datas --}}
<div class="modal fade show" id="modal-import" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><strong>Import datas!</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12 alert thanLess" style="display:none;background-color:#F7D7DA">
                        <span id="thanLess"></span>
                    </div>
                    <label for="">Import excel/ XLS,XLSX or CSV</label>
                    <div class="">
                        <input type="file" class="form-control" name="result_file" id="result_file" accept=".xls, .xlsx, .csv">
                    </div>
                </div>
                <div class="text-end float-right">
                    <div class="btn-hidden-show">
                        <button class="btn btn-primary waves-effect waves-themed submit-btn upload_file_data" type="button">Submit</button>
                    </div>
                    <div class="btn-impot-loading mt-3" style="display: none">
                        <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
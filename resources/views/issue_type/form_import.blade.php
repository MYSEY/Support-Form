<div id="importModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import issue type</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="card-title mb-1">@lang('lang.import_excel_/_XLS_XLSX_or_CSV')</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert thanLess-e" style="display:none;background-color:#F7D7DA">
                                <span id="thanLess-e"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file_e">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-lg-right mt-2">
                    <a href="javascript:" class="btn btn-primary submit-btn upload_file_data btn-text-submit">
                        <span class="btn-text-submit">@lang('lang.submit')</span>
                    </a>
                    <button class="btn btn-info waves-effect waves-themed" id="e-btn-loading"  type="button" style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



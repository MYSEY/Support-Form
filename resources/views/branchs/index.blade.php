@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Branch
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-tag">
                    <div class="text-lg-right">
                        <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#default-example-modal-lg-center" type="button"><span><i class="fal fa-plus mr-1"></i> Add</span></button>
                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#default-example-modal-lg-center">Add New</button> --}}
                    </div>
                </div>
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name (KH)</th>
                                <th>Name (EN)</th>
                                <th>Location (KH)</th>
                                <th>Location (EN)</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>61</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create New Department -->
<div class="modal fade" id="default-example-modal-lg-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">Name(KH)</label>
                        <input type="text" id="simpleinput" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">Name(EN)</label>
                        <input type="text" id="simpleinput" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (KH)</label>
                        <textarea class="form-control" id="example-textarea" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="example-textarea">Location (EN)</label>
                        <textarea class="form-control" id="example-textarea" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    {{-- @include('includs.datatables_alteditor') --}}
@endsection

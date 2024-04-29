@extends('layouts.admin')
@section('content')
<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Insert a new ticket <span class="fw-300"><i>inputs</i></span>
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <div class="panel-tag">
                Required fields are marked with <span class="text-danger">*</span>
            </div>
            <form>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label" for="example-select">Department: <span class="text-danger">*</span></label>
                            <select class="form-control" id="example-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Name: <span class="text-danger">*</span></label>
                            <input type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-email-2">Email: <span class="text-danger">*</span></label>
                            <input type="email" id="example-email-2" name="example-email-2" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-email-2">Ticket templates (<a type="button" href="#" >Manage ticket templates</a>)</label>
                            <div class="demo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="defaultUncheckedRadio" name="defaultExampleRadios" checked="">
                                    <label class="custom-control-label" for="defaultUncheckedRadio">Add to the bottom</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="defaultCheckedRadio" name="defaultExampleRadios">
                                    <label class="custom-control-label" for="defaultCheckedRadio">Replace message</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-select">Select a ticket template:</label>
                            <select class="form-control" id="example-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-select">Assign this ticket to:</label>
                            <select class="form-control" id="example-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="form-label" for="example-select">Priority: <span class="text-danger">*</span></label>
                            <select class="form-control" id="example-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-select">Sub Issue Types: <span class="text-danger">*</span></label>
                            <select class="form-control" id="example-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-email-2">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="example-email-2" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="example-select">Options:</label>
                            <div class="demo">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked" checked="">
                                    <label class="custom-control-label" for="defaultUnchecked">Send email notification to the customer</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultChecked" checked="">
                                    <label class="custom-control-label" for="defaultChecked">Show the ticket after submissio</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-muted" for="example-date-disabled">Due date:</label>
                            <input class="form-control" id="example-date-disabled" type="date" name="date">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attachments:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-3">
                        <div class="form-group">
                            <label class="form-label" for="example-textarea">Message: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="example-textarea" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" type="button">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
       
    </script>
@endsection


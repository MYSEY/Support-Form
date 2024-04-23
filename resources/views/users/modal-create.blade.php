<div class="modal fade" id="user-create" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-right"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Add new user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <form class="needs-validation" novalidate>
                <div class="modal-body">
                    <div id="panel-6" >
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="demo-v-spacing">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active fs-xs py-1 px-1" data-toggle="tab" href="#tab-user" role="tab">
                                                <span class="hidden-sm-down ml-1">Profile information</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link fs-xs py-1 px-1" data-toggle="tab" href="#tab-profile" role="tab">
                                                <span class="hidden-sm-down ml-1">Permissions</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link fs-xs py-1 px-1" data-toggle="tab" href="#tab-time" role="tab">
                                                <span class="hidden-sm-down ml-1">Signature</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link fs-xs py-1 px-1" data-toggle="tab" href="#tab-preferences" role="tab">
                                                <span class="hidden-sm-down ml-1">Preferences</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link fs-xs py-1 px-1" data-toggle="tab" href="#tap-notifications" role="tab">
                                                <span class="hidden-sm-down ml-1">Notifications</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content py-3">
                                        <div class="tab-pane fade show active" id="tab-user" role="tabpanel">
                                            <div class="form-group">
                                                <label class="form-label" for="user">Real name</label>
                                                <input type="text" id="user" class="form-control user_required" name="user" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control user_required" placeholder="Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="name">Username</label>
                                                <input type="text" id="name" name="name" class="form-control user_required" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" id="password" class="form-control user_required" name="password" required>
                                                <p id="passwordError" style="color: red;"></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="confirm_password">Confirm password</label>
                                                <input type="password" id="confirm_password" class="form-control user_required" name="confirm_password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="frame-wrap demo">
                                                    <div class="demo">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="auto_assign" name="autoassign" value="0">
                                                            <label class="custom-control-label" for="auto_assign">Auto-assign tickets to this user.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-profile" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade" id="tab-time" role="tabpanel">
                                            <label class="form-label" for="signature">Signature (max 1000 chars)</label>
                                            <textarea class="form-control" id="signature" name="signature" rows="6" maxlength="1000"></textarea>
                                        </div>
                                        <div class="tab-pane fade" id="tab-preferences" role="tabpanel">
                                            <h5 class="frame-heading">After replying to a ticket</h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="defaultUncheckedRadio1" name="defaultExampleRadios" checked="">
                                                        <label class="custom-control-label" for="defaultUncheckedRadio1">Show the ticket I just replied to</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="defaultCheckedRadio2" name="defaultExampleRadios">
                                                        <label class="custom-control-label" for="defaultCheckedRadio2">Return to main administration page</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input active" id="defaultUncheckedRadio3" name="defaultExampleRadios">
                                                        <label class="custom-control-label" for="defaultUncheckedRadio3">Open next ticket that needs my reply</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">Defaults</h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked1" checked="">
                                                        <label class="custom-control-label" for="defaultUnchecked1">Automatically start timer when I open a ticket</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultChecked1" checked="">
                                                        <label class="custom-control-label" for="defaultChecked1">Select notify customer option in the new ticket form</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultIndeterminate1" checked="">
                                                        <label class="custom-control-label" for="defaultIndeterminate1">Select notify customer option in the ticket reply form</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultIndeterminate12" checked="">
                                                        <label class="custom-control-label" for="defaultIndeterminate12">Show what knowledgebase articles were suggested to customers</label>
                                                    </div>
                                                </div>
                                                <div class="custom-control custom-checkbox" style="display: flex; -ms-flex-align: center; align-items: center; margin-top: -5px;">
                                                    <input type="checkbox" class="custom-control-input" id="defaultIndeterminate3">
                                                    <label class="custom-control-label" for="defaultIndeterminate3" style="font-weight: 1 !important;">Automatically reload page with ticket list every:</label>
                                                    <div class="form-group" style="width: 45px !important; margin-left: 8px; margin-bottom: 0;">
                                                        <input type="text" class="form-control" name="reload_time" value="30" maxlength="5" onkeyup="this.value=this.value.replace(/[^\d]+/,'')">
                                                    </div>
                                                    <div class="form-group ml-1">
                                                        <select class="form-control" id="example-select" style="border: 0px solid #E5E5E5 !important;">
                                                            <option>seconds</option>
                                                            <option>minutes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tap-notifications" role="tabpanel">
                                            <h5 class="frame-heading">The help desk will send an email notification when:</h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked2" checked="">
                                                        <label class="custom-control-label" for="defaultUnchecked2">A new ticket is submitted with owner: Unassigned</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="defaultChecked2" checked="">
                                                        <label class="custom-control-label" for="defaultChecked2">A new ticket is submitted with owner: Assigned to me</label>
                                                    </div>
                                                    <br>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="unassigned1" checked="">
                                                        <label class="custom-control-label" for="unassigned1">Client responds to a ticket with owner: Unassigned</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="assigned1" checked="">
                                                        <label class="custom-control-label" for="assigned1">Client responds to a ticket with owner: Assigned to me</label>
                                                    </div>
                                                    <br>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="Unassigned2" checked="">
                                                        <label class="custom-control-label" for="Unassigned2">A ticket is overdue with owner: Unassigned*</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="assigned3" checked="">
                                                        <label class="custom-control-label" for="assigned3">A ticket is overdue with owner: Assigned to me*</label>
                                                    </div>
                                                    <br>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="assigned4" checked="">
                                                        <label class="custom-control-label" for="assigned4">A ticket is assigned to me</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="assigned5" checked="">
                                                        <label class="custom-control-label" for="assigned5">Someone adds a note to a ticket assigned to me</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="message" checked="">
                                                        <label class="custom-control-label" for="message">A private message is sent to me</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-back" class="btn btn-outline-secondary waves-effect waves-themed">Back</button>
                    <button type="submit" id="btn-save" class="btn btn-primary ml-auto waves-effect waves-themed">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

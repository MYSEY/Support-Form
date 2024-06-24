<div class="tab-pane fade active show" id="js_change_pill_direction-1" role="tabpanel">
    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department/Branch</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data_tickets)>0)
                @foreach ($data_tickets as $key=>$item)
                    <tr>
                        <td></td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i A') ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-M-Y h:i A') ?? '' }}</td>
                        <td>
                            {{ $item->department ? $item->department->name_english: ""}}
                            {{  $item->branch ? $item->branch->branch_name_en: ""}}
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->subject}}</td>
                        <td></td>
                        <td>{{$item->createdBy->name}}</td>
                        <td></td>
                        <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d-M-Y') ?? '' }}</td>
                        <td></td>createdBy
                        <td>
                            <div style="display: flex">
                                <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:{{$item->priorities->color}};"></i> <span>{{$item->priorities->name}}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-2" role="tabpanel">
    <table id="dt-basic-assign" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>
                    <div style="display: flex">
                        <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>$320,800</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-3" role="tabpanel">
    <table id="dt-basic-assign-other" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>
                    <div style="display: flex">
                        <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>$320,800</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-4" role="tabpanel">
    <table id="dt-basic-unassigned" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>
                    <div style="display: flex">
                        <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>$320,800</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-5" role="tabpanel">
    <table id="dt-basic-due-soon" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>
                    <div style="display: flex">
                        <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>$320,800</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-6" role="tabpanel">
    <table id="dt-basic-overdue" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Submitted</th>
                <th>Updated</th>
                <th>Department</th>
                <th>Name</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Last Replier</th>
                <th>Due Date</th>
                <th>Sub Issue Type</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>
                    <div style="display: flex">
                        <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px;"></i> <span>$320,800</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

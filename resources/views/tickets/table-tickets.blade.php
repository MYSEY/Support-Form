<div class="tab-pane fade active show" id="open_ticket" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-all" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($data_tickets) --}}
            {{-- @if (count($data_tickets)>0)
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
                        <td data-toggle="tooltip" data-html="true" title="{{$item->assignedBy ? "Assigned to: ".$item->assignedBy->name : "(".$item->assignedby.")" }}<br><br>{{nl2br(e($item->message))}}">
                            <a href="javascript:void(0)">{{$item->subject}}</a>
                        </td>
                        <td style="color: {{$item->CustomStatus->color}}">{{$item->CustomStatus->name}}</td>
                        <td>{{$item->assignedBy ? $item->assignedBy->name : $item->assignedby}}</td>
                        <td>{{$item->lastReplier ? $item->lastReplier->name : $item->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d-M-Y') ?? '' }}</td>
                        <td>
                            @php
                                $issueTypeArray = json_decode($item->issue_type, true);
                                $firstIssueType = $issueTypeArray[0] ?? '';
                            @endphp
                            {{ $firstIssueType }}
                        </td>
                        <td>
                            <div style="display: flex">
                                <i class="fal fa-bookmark fa-rotate-270 mr-2" style="font-size: 20px; color:{{$item->priorities->color}};"></i> <span>{{$item->priorities->name}}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif --}}
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="ticke_assigned" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-assign" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="js_change_pill_direction-3" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-assign-other" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="ticket_unassigned" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-unassigned" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="ticket_due_soon" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-due-soon" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="tab-pane fade" id="tiecket_overdue" role="tabpanel">
    <table data-order='[[ 4, "desc" ]]' id="dt-basic-overdue" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Tracking_ID</th>
                <th>Submitted</th>
                <th>From_Department/Branch</th>
                <th>Create_By</th>
                <th>To_Department</th>
                <th>Subjesct</th>
                <th>Status</th>
                <th>Ticket_Type</th>
                <th>Sub_Issue_Type</th>
                <th>Priority</th>
                <th>Assigned</th>
                <th>Last_Replier</th>
                <th>Due_Date</th>
                <th>Updated</th>
                <th>attachments</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

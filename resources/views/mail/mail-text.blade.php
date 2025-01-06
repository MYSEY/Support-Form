<div class="card">
    <div class="card-header">
        <p>Do not reply this email. This is auto reply from Camma Support Form System.</p>
        @if ($data["data_tickets"]->updatedBy)
            <p>Issue <a class="btn btn-primary" href="#">#{{$data["data_tickets"]->trackid}}</a> has been {{$data["status"] == "new" ? "create by ".$data["data_tickets"]->createdBy->name : "update by ".$data["data_tickets"]->updatedBy->name}}.</p>
        @else
            <p>Issue <a class="btn btn-primary" href="#">#{{$data["data_tickets"]->trackid}}</a> has been create by .{{$data["data_tickets"]->createdBy->name}}</p>
        @endif
    </div>
    <div class="card-body">
        <a class="btn btn-primary" href="{{url("http://hrms.camma.com:9090/Support-Form/public/admin/ticket/detail/").$data["data_tickets"]->id}}"><h3>I need support #{{$data["data_tickets"]->trackid}}: {{$data["data_tickets"]->subject}}</h3></a>
        {{-- <a class="btn btn-primary" href="#"><h3>I need support #{{$data["data_tickets"]->trackid}}: {{$data["data_tickets"]->subject}}</h3></a> --}}
        @if ($data["status"] != "new")
            <hr>
            @if ($data["dataReply"])
                <p class="card-text">
                    {!! nl2br(e($data["dataReply"]->message)) !!}
                </p>
            @endif
            <ul>
                @if ($data["data_assign"] == true)
                    <li>Assignee changed from 
                        @if ($data["data_tickets"]->updatedBy)
                            {{$data["data_tickets"]->updatedBy->name}}
                        @else
                            @if ($data["data_tickets"]->createdBy)
                                {{$data["data_tickets"]->createdBy->name}}
                            @else
                                {{$data["data_tickets"]->assignedTo}}
                            @endif
                        @endif
                        to 
                        {{
                            $data["data_tickets"]->assignedTo ? $data["data_tickets"]->assignedTo->name : $data["data_tickets"]->assignedTo
                        }}
                    </li>
                @endif
                @if ($data["dataHistoryStatus"])
                    <li>Status changed from 
                            {{$data["dataHistoryStatus"]->statusFrom->name}}
                        to 
                        {{
                            $data["dataHistoryStatus"]->statusTo->name
                        }}
                    </li>
                @endif
                @if ($data["dataHistoryPriority"])
                    <li>Priority changed 
                            {{$data["dataHistoryPriority"]->priorityFrom->name}}
                        to 
                        {{
                            $data["dataHistoryPriority"]->priorityTo->name
                        }}
                    </li>
                @endif
            </ul>
        @endif
        <hr>
        <ul>
            <li><strong>Create by:</strong> {{$data["data_tickets"]->createdBy->name}}</li>
            <li><strong>Status:</strong> {{$data["data_tickets"]->CustomStatus->name}}</li>
            <li><strong>Priority:</strong> {{$data["data_tickets"]->priorities->name}}</li>
            <li><strong>Assignee:</strong> {{$data["data_tickets"]->assignedTo ? $data["data_tickets"]->assignedTo->name : $data["data_tickets"]->assignedTo}}</li>
            <li><strong>Platform:</strong> Web</li>
            <li><strong>Issue Classification:</strong> {{$data["data_tickets"]->issueType->name}}</li>
        </ul>
        <hr>
        <p class="card-text">
            {!! nl2br(e($data["data_tickets"]->message)) !!}
        </p>
    </div>
</div>
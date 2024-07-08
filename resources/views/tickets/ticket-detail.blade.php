@extends('layouts.admin')
@section('content')
<style>
    .ticket-status {
        color: red;
    }
    .mark-as-resolved {
        color: blue;
    }
    .priority-high {
        color: orange;
    }
    .assign-link {
        color: blue;
    }
    .ticket-info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
</style>
{{-- <div id="panel-1" class="panel"> --}}
    {{-- <div class="container mt-5"> --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3>{{$data_ticket->subject}}</h3><br>
                        <h5 class="card-title">Contact: <span class="text-primary">{{$data_ticket->name}} ,</span>
                            <span class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}</span>
                        </h5>
                       @php
                            $issueTypeArray = json_decode($data_ticket->issue_type, true);
                            $firstIssueType = $issueTypeArray ?? '';
                        @endphp
                        @foreach ($firstIssueType as $type)
                            <p class="card-text">{{$type["title"]}}: {{$type["value"]}}</p>
                        @endforeach

                        <p class="card-text">
                            {!! nl2br(e($data_ticket->message)) !!}
                        </p>
                        <button class="btn btn-outline-success" id="btn-add-note">Add note</button>
                        <div class="form-noted mt-3" style="display: none;">
                            <div class="form-group">
                                <label class="form-label" for="ticket-textarea">Message: <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ticket-textarea" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" id="example-fileinput" class="form-control-file">
                            </div>
                            <button class="btn btn-danger">Submit</button>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="btn-group btn-group-custom d-flex justify-content-end" role="group" aria-label="Print Options">
                    <button type="button" class="btn btn-outline-primary"> <i class="fal fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-outline-primary"> <span class="fal fa-print mr-1"></span> Print</button>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fal fa-lock-alt"></i> Look ticket</a>
                        <a class="dropdown-item" href="#"><i class="fal fa-tags"></i> Tag ticket</a>
                        <a class="dropdown-item" href="#"><i class="fal fa-envelope"></i> Re-send email notification</a>
                        <a class="dropdown-item" href="#">Import to Knowledgebase</a>
                        <a class="dropdown-item" href="#"><i class="fal fa-arrow-to-bottom"></i> Export to Excel</a>
                        <a class="dropdown-item" href="#"><i class="fal fa-trash-alt"></i> Delete ticket</a>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="ticket-info-item d-flex justify-content-between align-items-center">
                            <span><strong>Ticket status:</strong></span>
                            <div>
                                <button style="text-decoration: none !important;" class="btn btn-link dropdown-toggle p-0" type="button" id="ticketStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span style="color: {{$data_ticket->CustomStatus->color}}">{{$data_ticket->CustomStatus->name}}</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="ticketStatus">
                                    @foreach ($status as $item)
                                        <a class="dropdown-item" href="#"><span style="color: {{$item->color}}">{{$item->name}}</span></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="ticket-info-item d-flex justify-content-end align-items-center">
                            <a href="#" class="mark-as-resolved ml-2">[Mark as Resolved]</a>
                        </div>

                        <div class="ticket-info-item d-flex justify-content-between align-items-center">
                            <span><strong>Department/Branch:</strong></span>
                            <div>
                                <button style="text-decoration: none !important;" class="btn btn-link dropdown-toggle p-0" type="button" id="categoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>
                                        {{ $data_ticket->department ? $data_ticket->department->name_english: ""}}
                                        {{ $data_ticket->branch ? $data_ticket->branch->branch_name_en: ""}}
                                    </span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    @foreach ($department as $item)
                                        <a class="dropdown-item" href="#">{{$item->name_english}}</a>
                                    @endforeach
                                    @foreach ($branch as $item)
                                        <a class="dropdown-item" href="#">{{$item->branch_name_en}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="ticket-info-item d-flex justify-content-between align-items-center">
                            <span><strong>Priority:</strong></span>
                            <div>
                                <button style="text-decoration: none !important;" class="btn btn-link dropdown-toggle p-0" type="button" id="priorityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="priority-high" style="color: {{$data_ticket->priorities->color}}">
                                        {{$data_ticket->priorities->name}}
                                    </span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="priorityDropdown">
                                    @foreach ($priority as $item)
                                        <a class="dropdown-item" href="#"><span style="color: {{$item->color}}">{{$item->name}}</span></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="ticket-info-item d-flex justify-content-between align-items-center">
                            <span><strong>Assigned to:</strong></span>
                            <div>
                                <button style="text-decoration: none !important;" class="btn btn-link dropdown-toggle p-0" type="button" id="assignedDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>{{$data_ticket->assignedBy ? $data_ticket->assignedBy->name : '> '.$data_ticket->assignedby.' <'}}</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="assignedDropdown">
                                    <a class="dropdown-item" href="#">> Unassigned <</a>
                                    <a class="dropdown-item" href="#">> Auto-assign <</a>
                                    @foreach ($user_support as $item)
                                        <a class="dropdown-item" href="#">{{$item->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="ticket-info-item d-flex justify-content-end align-items-center">
                            <a href="#" class="mark-as-resolved ml-2">[Assign to self]</a>
                        </div>
                    </div>
                </div>

                <div class="frame-wrap w-100 mt-4">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Ticket Details
                                    <span class="ml-auto">
                                        <span class="collapsed-reveal">
                                            <i class="fal fa-angle-up"></i>
                                            {{-- <i class="fal fa-minus-circle text-danger"></i> --}}
                                        </span>
                                        <span class="collapsed-hidden">
                                            <i class="fal fa-angle-down"></i>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="card-text">Tracking ID: <strong class="ml-3">{{$data_ticket->trackid}}</strong></p>
                                    <p class="card-text">Ticket number: <strong class="ml-3">{{$data_ticket->id}}</strong></p>
                                    <p class="card-text">Created on: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}</strong></p>
                                    <p class="card-text">Updated: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->updated_at)->format('d-M-Y h:i A') ?? '' }}</strong></p>
                                    <p class="card-text">Replies: <strong class="ml-3">0</strong></p>
                                    <p class="card-text">Last replier: <strong class="ml-3">0</strong></p>
                                    <p class="card-text">Time worked: <strong class="ml-3">00:00</strong></p>
                                    <p class="card-text">Due date: <strong class="ml-3">{{ \Carbon\Carbon::parse($data_ticket->due_date)->format('d-M-Y') ?? '' }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="frame-wrap w-100">
                    <div class="accordion" id="History">
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Ticket History
                                    <span class="ml-auto">
                                        <span class="collapsed-reveal">
                                            <i class="fal fa-angle-up"></i>
                                            {{-- <i class="fal fa-minus-circle text-danger"></i> --}}
                                        </span>
                                        <span class="collapsed-hidden">
                                            <i class="fal fa-angle-down"></i>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#History">
                                <div class="card-body">
                                    <p class="card-text">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">ticket created by {{$data_ticket->createdBy->name}}</strong></p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Ticket History</h5>
                        <p class="card-text">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}: <strong class="ml-3">ticket created by {{$data_ticket->createdBy->name}}</strong></p>
                        
                    </div>
                </div> --}}
            </div>
        </div>
       
    
    {{-- </div> --}}
{{-- </div> --}}
@endsection
@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
       $("#btn-add-note").click(function(){
            $(".form-noted").toggle();
        });
    </script>
@endsection
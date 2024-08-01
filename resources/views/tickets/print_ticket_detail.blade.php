<div id="print_purchase" hidden>
    <div class="card-header">
        {{-- logo company --}}
        <div>
            <div style="text-align: center" class="font-title">
                <label class="title">ព្រះរាជាណាចក្រកម្ពុជា</label><br>
                <label style="font-size: 16px">ជាតិ សាសនា ព្រះមហាក្សត្រ</label><br>
                {{-- <img style="width: 10% ;height: 1.2%;"alt='White' id="image_logo_print" src="{{ asset('/admins/img/bitbucket-logo.png') }}"> --}}
            </div>
            <div style="margin-top: -75px; margin-left: -6%">
                <img style="width:auto;height: 10%;"alt='White' id="image_logo_print"
                src="{{ asset('/admins/img/logo/commalogo1.png') }}">
            </div>
        </div><br>
        <div style="display:flex;" class="set-font">
            <div style="width: 487%;">
                <label class="label-sub_lll">Reference Ticket</label>
                <div class="">
                    <div>
                        <table style="width:100%">
                            <tr>
                                <td class="table_tr">Subject:</td>
                                <td class="table_tr">{{$data_ticket->subject}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Tracking ID:</td>
                                <td class="table_tr"> {{$data_ticket->trackid}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Ticket status:</td>
                                <td class="table_tr">{{$data_ticket->CustomStatus->name}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Created on:</td>
                                <td class="table_tr">{{ \Carbon\Carbon::parse($data_ticket->created_at)->format('d-M-Y h:i A') ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Updated:</td>
                                <td class="table_tr">{{ \Carbon\Carbon::parse($data_ticket->updated_at)->format('d-M-Y h:i A') ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Assigned to:</td>
                                <td class="table_tr">{{$data_ticket->assignedBy ? $data_ticket->assignedBy->name : '> '.$data_ticket->assignedby.' <'}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Last replier:</td>
                                <td class="table_tr"></td>
                            </tr>
                            <tr>
                                <td class="table_tr">Category:</td>
                                <td class="table_tr"></td>
                            </tr>
                            <tr>
                                <td class="table_tr">Due date:</td>
                                <td class="table_tr">{{ \Carbon\Carbon::parse($data_ticket->due_date)->format('d-M-Y') ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Email:</td>
                                <td class="table_tr">{{$data_ticket->email}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Name</td>
                                <td class="table_tr">{{$data_ticket->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <td class="table_tr">Issue Types:</td>
                                <td class="table_tr">{{$data_ticket->issueType->name}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <table style="width:100%">
                    <tr><td class="table_tr">
                        {!! nl2br(e($data_ticket->message)) !!}
                    </td></tr>
                </table>
                <table style="width:100%" class="tbl-noted">
                </table>
                <table style="width:100%" class="tbl-reply">
                </table>
            </div>
        </div><br><br>
        <p style="text-align: center">--- End of ticket ---</p>
    </div>
</div>


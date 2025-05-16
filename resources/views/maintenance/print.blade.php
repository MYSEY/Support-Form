<div id="btnPrint" hidden>
    <div class="card-header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('/admins/img/logo/commalogo1.png') }}" alt="Logo" style="height: 50px; width: auto; margin-right: 10px;">
                <label style="font-family: Calibri Light; font-size: 14px; font-weight: bold;">Camma Microfinance Limited</label>
            </div>
            <div>
                <label style="font-size: 11px;">Date: {{$data->maintenance_date}}</label>
            </div>
        </div>
        
        <div style="display: flex;margin-top: -5px;">
            <div style="margin-right: 100px;">
                <label style="font-family: Calibri Light; font-size: 14px; font-weight: bold;"></label>
            </div>
            <div style="margin-right: 40px;text-align: center">
                <label style="font-family: Calibri Light; font-size: 14px; font-weight: bold;">Maintenance</label>
            </div>
            <div style="flex: 1; text-align: center;">
                <label style="font-size: 11px;">Serial: {{$data->serial}}</label>
            </div>
            <div style="flex: 1; text-align: center;">
                <label style="font-size: 11px;">IT Technician: {{$data->maintenace_by}}</label>
            </div>
        </div>
        <div style="border-bottom: 2px solid #7e7e7e;"></div>

        <div style="font-size: 11px;text-align: center">
            <p>
                <strong>
                    Category : <span>{{$data->category_name}}</span>, 
                    Device Name : <span>{{$data->device_name}}</span>, 
                    Office : <span>{{$data->branch_name_en}}</span>, 
                    Location : <span>{{$data->location}}</span>,
                    End User : <span>{{$data->employee_name_en}}</span>,
                    Postion : <span>{{$data->name_english}}</span>,
                    Date Purchase : <span>{{$data->date}}</span>,
                    Lifecycle(Month) : <span>{{$data->LifecycleMonthDiff}}</span>
                </strong>
            </p>
        </div>
        <div style="border-bottom: 2px solid #7e7e7e;"></div>
        <br>
        <div class="row">
            <!-- Hardware Table -->
            @if (count($hardwareItems)>0)
                <div class="col-xl-6">
                    <div class="form-group">
                        <table class="table table-bordered table-striped" style="font-size: 11px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 45%;">Maintenance Hardware</th>
                                    <th style="width: 50%;">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hardwareItems = collect($data->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Hardware');
                                @endphp
                                
                                @forelse ($hardwareItems as $hardKey => $item)
                                    <tr>
                                        <td>{{ $hardKey + 1 }}</td>
                                        <td>{{ optional($item->task)->name ?? 'N/A' }}</td>
                                        <td>{{ $item->note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hardware data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        
            <!-- Software Table -->
            @if (count($softwareItems)>0)
                <div class="col-xl-6">
                    <div class="form-group">
                        <table class="table table-bordered table-striped" style="font-size: 11px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 45%;">Maintenance Software</th>
                                    <th style="width: 50%;">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $softCounter = 1;
                                    $softwareItems = collect($data->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Software');
                                @endphp
                                @forelse ($softwareItems as $softKey => $item)
                                    <tr>
                                        <td>{{ $softCounter++ }}</td>
                                        <td>{{ optional($item->task)->name ?? 'N/A' }}</td>
                                        <td>{{ $item->note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No software data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <br>
        <div class="row mb-2">
            <div class="col-xl-12" style="font-size: 11px;">
                <div class="form-group">
                    <label class="form-label" for="Noted">Note:</label>
                    <div class="card-text">{!! $data->description !!}</div>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <strong>End User</strong><br><br><br><br><br>
                Name: __________________
            </div>

            <div class="signature-box">
                <strong>Technician</strong><br><br><br><br><br>
                Name: {{$data->maintenace_by}}
            </div>
        </div>
    </div>
</div>
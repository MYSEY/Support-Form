@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h3>
                Maintanance History 
            </h3>
        </div>
        <div class="col-md-8" style="text-align: right;">
            <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('admin/report/maintenance')}}" type="button">Back</a>
        </div>
    </div>
    @foreach ($data as $item)
        <div class="row mb-2">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="panel-content">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Serial</strong> : <span style="font-weight: bold;">{{ $item->serial }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Maintenance Date</strong> : <span style="font-weight: bold;">{{ $item->maintenance_date }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>IT Technician</strong> : <span style="font-weight: bold;">{{ $item->maintenace_by }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Category</strong> : <span style="font-weight: bold;">{{ $item->category_name }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Device Name</strong> : <span style="font-weight: bold;">{{ $item->device_name }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Office</strong> : <span style="font-weight: bold;">{{ $item->branch_name_en }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Location</strong> : <span style="font-weight: bold;">{{ $item->location }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>End User</strong> : <span style="font-weight: bold;">{{ $item->employee_name_en }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Postion</strong> : <span style="font-weight: bold;">{{ $item->name_english }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Date Purchase</strong> : <span style="font-weight: bold;">{{ $item->date }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Lifecycle(Month)</strong> : <span style="font-weight: bold;">{{ $item->LifecycleMonthDiff }}</span>
                                </div>
                            </div>
                        </div>
                        <br>
                        @php
                            $softCounter = 1;
                            $softwareItems = collect($item->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Software');
                            $hardwareItems = collect($item->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Hardware');
                        @endphp
                        <div class="row mb-3">
                            <!-- Hardware Table -->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <h4>Hardware</h4>
                                    <table id="tbl_hardware" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($hardwareItems as $hardKey => $item)
                                                <tr class="odd">
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
                            <!-- Software Table -->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <h4>Software</h4>
                                    <table id="tbl_software" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($softwareItems as $softKey => $value)
                                                <tr class="odd">
                                                    <td>{{ $softCounter ++ }}</td>
                                                    <td>{{ optional($value->task)->name ?? 'N/A' }}</td>
                                                    <td>{{ $value->note}}</td>
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
                        </div>

                        <div class="row mb-2">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label class="form-label" for="Noted">Note:</label>
                                    <div class="card-text">{!! $item->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
    @endforeach
@endsection
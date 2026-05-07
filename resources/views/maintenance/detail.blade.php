@extends('layouts.admin')
@section('content')
    <style>
        .text-success {
            color: green;
        }

        .text-warning {
            color: orange;
        }
        .text-red {
            color: rgb(238, 29, 63);
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>
                                Maintenance Detail 
                            </h3>
                        </div>
                        <div class="col-md-8" style="text-align: right;">
                            <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('admin/report/maintenance')}}" type="button">Back</a>
                            @can('Maintenance Print')
                                <button type="button" class="btn btn-outline-primary btn-print"> <span class="fal fa-print mr-1"></span>Print</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <div class="">
                        <div class="panel-content">
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="Serial">Serial</label>
                                        <input type="text" name="serial" class="form-control" disabled id="serial" value="{{$data->serial}}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Maintenance Date</label>
                                        <input type="date" name="maintenance_date" class="form-control" disabled id="maintenance_date" value="{{$data->maintenance_date}}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="maintenace_by">IT Technician</label>
                                        <input type="text" name="maintenace_by" class="form-control" disabled id="maintenace_by" value="{{$data->maintenace_by}}">
                                    </div>
                                </div>
                            </div>
                            <div style="border: 1px solid #e9e9e9;padding: 0.75rem;">
                                <p>
                                    <strong>Category :</strong> <span>{{$data->category_name}}</span>, 
                                    <strong>Device Name</strong> : <span>{{$data->device_name}}</span>, 
                                    <strong>Office</strong> : <span>{{$data->branch_name_en}}</span>, 
                                    <strong>Location</strong> : <span>{{$data->location}}</span>,
                                    <strong>End User</strong> : <span>{{$data->employee_name_en}}</span>,
                                    <strong>Postion</strong> : <span>{{$data->name_english}}</span>,
                                    <strong>Date Purchase</strong> : <span>{{$data->date}}</span>,
                                    <strong>Lifecycle(Month)</strong> : <span>{{$data->LifecycleMonthDiff}}</span>
                                </p>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <!-- Hardware Table -->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <h3>Hardware</h3>
                                        <table id="tbl_hardware" class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $hardwareItems = collect($data->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Hardware');
                                                @endphp
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
                                        <h3>Software</h3>
                                        <table id="tbl_software" class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $softCounter = 1;
                                                    $softwareItems = collect($data->maintenanceDetail)->filter(fn($item) => optional($item->task)->type === 'Software');
                                                @endphp
                                                @forelse ($softwareItems as $softKey => $item)
                                                    <tr class="odd">
                                                        <td>{{ $softCounter ++ }}</td>
                                                        <td>{{ optional($item->task)->name ?? 'N/A' }}</td>
                                                        <td>{{ $item->note}}</td>
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
                                        <div class="card-text">{!! $data->description !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('maintenance.print')
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('/admins/js/printThis.js') }}"></script>
    @include('includs.datatable_basic')
    <script type="text/javascript">
        $(function(){
            $(".btn-print").on("click", function() {
                print_pdf();
            });
        });

        function print_pdf() {
            $("#btnPrint").show();
            $("#btnPrint").printThis({
                importCSS: false,
                importStyle: true,
                loadCSS: "{{ asset('/admins/css/style_print_maitenance.css') }}",
                header: "",
                printDelay: 1500,
                formValues: false,
                canvas: false,
                doctypeString: "",
            });
        }
    </script>
@endsection
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
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintenance
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <form action="{{url('admin/asset')}}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="panel-content">
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="Serial">Serial <span class="text-danger">*</span></label>
                                        <select class="select2 form-control w-100 select2-hidden-accessible" id="serial" name="serial" required>
                                            <option value="">-- Select --</option>
                                            @foreach ($serial as $item)
                                                <option value="{{$item->id}}">{{ $item->serial}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">Date <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control required" id="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">IT Technician <span class="text-danger">*</span></label>
                                        <input type="text" name="" class="form-control required" id="" value="{{Auth::user()->name}}" required>
                                    </div>
                                </div>
                            </div>
                            <div style="border: 1px solid #e9e9e9;padding: 0.75rem;">
                                <p>
                                    <strong>Category :</strong> <span class="category"></span>, 
                                    <strong>Device Name</strong> : <span class="device_name"></span>, 
                                    <strong>Office</strong> : <span class="office"></span>, 
                                    <strong>Location</strong> : <span class="location"></span>,
                                    <strong>End User</strong> : <span class="employee"></span>,
                                    <strong>Postion</strong> : <span class="position"></span>,
                                    <strong>Date</strong> : <span class="date"></span>,
                                    <strong>Lifecycle(Month)</strong> : <span class="lifecycle_month"></span>
                                </p>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Maintenance Hardware</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Adobe Acrobat DC/Pro XI</td>
                                                    <td>Ok</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Maintenance Software</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Adobe Acrobat DC/Pro XI</td>
                                                    <td>Ok</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Noted">Note:</label>
                                        <textarea class="form-control" id="description" name="description" rows="6" maxlength="1000"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-md-right">
                                <div class="btn-hidden-show">
                                    <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/asset')}}"  type="button">Cancel</a>
                                    <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" type="submit">Submit</button>
                                </div>
                                <input type="hidden" value="{{csrf_token()}}" id="token"/>
                                <div class="btn-loading mt-3" style="display: none">
                                    <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
        $(function(){
            $("#serial").on('change', function(){
                var serial = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/serial') }}",
                    data: { 
                        serial : serial 
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $(".employee").text(response.message.employee_name_en);
                        $(".position").text(response.message.name_english);
                        $(".category").text(response.message.category_name);
                        $(".device_name").text(response.message.device_name);
                        $(".office").text(response.message.branch_name_en);
                        $(".location").text(response.message.location);
                        $(".date").text(response.message.date);
                        $(".lifecycle_month").text(getLifecycleMonthDiff(response.message.date));
                        let lifecycle_month = getLifecycleMonthDiff(response.message.date);
                        let colorClass = '';
                        if (lifecycle_month >= 1 && lifecycle_month <= 50) {
                            colorClass = 'text-success';  // Green
                        } else if (lifecycle_month >= 51 && lifecycle_month <= 60) {
                            colorClass = 'text-warning';  // Yellow
                        }else{
                            colorClass = 'text-red';  // Yellow
                        }
                        // Apply the color class
                        $(".lifecycle_month").removeClass("text-success text-warning text-red").addClass(colorClass);
                    }
                });
            });
        });

        function getLifecycleMonthDiff(startDate) {
            let defaultMonth = 60;
            // Parse startDate to a Date object
            let start = new Date(startDate);
            let current = new Date();
            // Calculate the difference in months
            let diffInMonths = (current.getFullYear() - start.getFullYear()) * 12 + (current.getMonth() - start.getMonth());
            // Apply the same logic as Laravel
            return diffInMonths >= 60 ? -(diffInMonths - defaultMonth) : diffInMonths;
        }
    </script>
@endsection
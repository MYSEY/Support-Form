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
        .sub-message {
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Maintanance
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row mb-2">
                            <div class="col-xl-4">
                                <div class="form-group form-group-select2">
                                    <label class="form-label" for="branch_id">Branch <span class="text-danger">*</span></label>
                                    <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="branch_id" name="branch_id">
                                        <option value="">-- Select --</option>
                                        @foreach ($branch as $item)
                                        <option value="{{$item->id}}" {{$data->office == $item->id ? 'selected' : ''}}>{{ $item->branch_name_en}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group form-group-select2">
                                    <label class="form-label" for="Serial">Serial <span class="text-danger">*</span></label>
                                    <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="serial" name="serial" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($serial as $item)
                                            <option value="{{$item->id}}" {{$data->asset_id == $item->id ? 'selected' : ''}}>{{ $item->serial}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="">Maintanance Date <span class="text-danger">*</span></label>
                                    <input type="date" name="maintenance_date" class="form-control required" id="maintenance_date" value="{{ $data->maintenance_date}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="maintenace_by">IT Technician <span class="text-danger">*</span></label>
                                    <input type="text" name="maintenace_by" class="form-control required" disabled id="maintenace_by" value="{{ $data->maintenace_by}}" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group form-group-select2">
                                    <label class="form-label" for="maintenance_mission_id">Maintenance Mission</label>
                                    <select class="select2 form-control w-100 select2-hidden-accessible select2-option" id="maintenance_mission_id" name="maintenance_mission_id">
                                        <option value="">-- Select --</option>
                                        @foreach ($maintenanceMission as $item)
                                        <option value="{{$item->id}}" {{$data->maintenance_mission_id == $item->id ? 'selected' : ''}}>{{ $item->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="reference">Reference</label>
                                    <input type="text" name="reference" class="form-control" id="reference" value="{{ $data->reference}}">
                                </div>
                            </div>
                        </div>
                        <div style="border: 1px solid #e9e9e9;padding: 0.75rem;">
                            <p>
                                <strong>Category :</strong> <span class="category">{{$data->category_name}}</span>, 
                                <strong>Device Name</strong> : <span class="device_name">{{$data->device_name}}</span>, 
                                <strong>Office</strong> : <span class="office">{{$data->branch_name_en}}</span>, 
                                <strong>Location</strong> : <span class="location">{{$data->location}}</span>,
                                <strong>End User</strong> : <span class="employee">{{$data->employee_name_en}}</span>,
                                <strong>Postion</strong> : <span class="position">{{$data->name_english}}</span>,
                                <strong>Date Purchase</strong> : <span class="date">{{$data->date}}</span>,
                                <strong>Lifecycle(Month)</strong> : <span class="lifecycle_month">{{$data->LifecycleMonthDiff}}</span>
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
                                                <th>
                                                    <div class="form-group">
                                                        <div class="frame-wrap">
                                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input" id="defaultInlineHardware" onclick="handleCheckAllHardware(this)">
                                                                <label class="custom-control-label" for="defaultInlineHardware"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $hardwareIndex = 1; @endphp
                                            @foreach ($hardwareTasks as $item)
                                                @php
                                                    $taskIds = array_column($selectedTaskIds->toArray(), 'task_id');
                                                    $isChecked = in_array($item->task_id, $taskIds) ? 'checked' : '';
                                                    $noteDetail = $selectedTaskIds->firstWhere('task_id', $item->task_id);
                                                    $note = $noteDetail ? $noteDetail['note'] : '';
                                                @endphp
                                                <tr class="odd">
                                                    <td>{{ $hardwareIndex++ }}</td>
                                                    <td class="sub-message" data-toggle="tooltip" data-html="true" title="{{$item->description}}">{{ $item->task_name ?? 'N/A' }}</td>
                                                    <td>
                                                        <textarea class="form-control" id="note_{{ $item->task_id }}" name="note[]" rows="2" maxlength="100">{{$note}}</textarea>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="frame-wrap">
                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input check_all_hardware" name="tasks[]" id="task_{{ $item->task_id }}" value="{{ $item->task_id }}" {{ $isChecked }} onclick="handleCheckboxClick(this)">
                                                                    <label class="custom-control-label" for="task_{{ $item->task_id }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                                                <th>
                                                    <div class="form-group">
                                                        <div class="frame-wrap">
                                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input" id="defaultInlineSoftware" onclick="handleCheckAllSoftware(this)">
                                                                <label class="custom-control-label" for="defaultInlineSoftware"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $softwareIndex = 1; @endphp
                                            @foreach ($softwareTasks as $item)
                                                @php
                                                    $taskIds = array_column($selectedTaskIds->toArray(), 'task_id');
                                                    $isChecked = in_array($item->task_id, $taskIds) ? 'checked' : '';
                                                    $noteDetail = $selectedTaskIds->firstWhere('task_id', $item->task_id);
                                                    $note = $noteDetail ? $noteDetail['note'] : '';
                                                @endphp
                                                <tr class="odd">
                                                    <td>{{ $softwareIndex++ }}</td>
                                                    <td class="sub-message" data-toggle="tooltip" data-html="true" title="{{$item->description}}">{{ $item->task_name ?? 'N/A' }}</td>
                                                    <td>
                                                        <textarea class="form-control" id="note_{{ $item->task_id }}" name="note[]" rows="2" maxlength="100">{{$note}}</textarea>
                                                        {{-- <textarea class="form-control" id="note_{{ $item->task_id }}" name="note[]" rows="2" maxlength="100"></textarea> --}}
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="frame-wrap">
                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input check_all_software" name="tasks[]" id="task_{{ $item->task_id }}" value="{{ $item->task_id }}" {{ $isChecked }} onclick="handleCheckboxClick(this)">
                                                                    <label class="custom-control-label" for="task_{{ $item->task_id }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                        
                        <div class="row mb-2">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Note:</label>
                                    <textarea name="description" id="description" class="form-control">{!! $data->description !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-md-right">
                            <div class="btn-hidden-show">
                                <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/maintenance')}}"  type="button">Cancel</a>
                                <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn_update" type="submit">Submit</button>
                            </div>
                            <input type="hidden" value="{{csrf_token()}}" id="token"/>
                            <input type="hidden" name="id" id="id" value="{{$data->id}}">
                            <input type="hidden" name="category_id" id="category_id" value="{{$data->category_id}}">
                            <input type="hidden" name="location_id" id="location_id" value="{{$data->location_id}}">
                            <input type="hidden" name="end_user" id="end_user" value="{{$data->end_user}}">
                            <input type="hidden" name="device_id" id="device_id">
                            <input type="hidden" name="department_id" id="department_id" value="{{$data->department_id}}">
                            <div class="btn-loading mt-3" style="display: none">
                                <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
        $(function(){
            $('#description').summernote({
                height: 200,  // Set height of editor
                placeholder: 'Write your notes here...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
            $("#branch_id").on('change', function(){
                var branch_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/onchange/branch') }}",
                    data: { 
                        branch_id : branch_id 
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $('#serial').html('<option selected > -- Select --</option>');
                        $.each(response.message, function(i, item) {
                            $('#serial').append($('<option>', {
                                value: item.id,
                                text: item.serial
                            }));
                        });
                    }
                });
            });
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
                        $("#category_id").val(response.message.category_id);
                        $("#location_id").val(response.message.location_id);
                        $("#end_user").val(response.message.end_user);
                        $(".employee").text(response.message.employee_name_en);
                        $(".position").text(response.message.name_english);
                        $(".category").text(response.message.category_name);
                        $(".device_name").text(response.message.device_name);
                        $("#device_id").val(response.message.device_name);
                        $("#department_id").val(response.message.department_id);
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

                        let hardwareTr = "";
                        let softwareTr = "";
                        if (response.task.length > 0) {
                            let hardwareIndex = 1;
                            let softwareIndex = 1;
                            response.task.forEach((row) => {
                                if (row.type == "Hardware") {
                                    hardwareTr += `<tr class="odd">
                                        <td>${hardwareIndex++}</td>
                                        <td>${row.task_name}</td>
                                        <td>
                                            <textarea class="form-control" id="note_${row.task_id}" name="note[]" rows="2" maxlength="100"></textarea>
                                        <td>
                                            <div class="form-group">
                                                <div class="frame-wrap">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input check_all_hardware" name="tasks[]" id="task_${row.task_id}" value="${row.task_id}" onclick="handleCheckboxClick(this)">
                                                        <label class="custom-control-label" for="task_${row.task_id}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;
                                } else if (row.type == "Software") {
                                    softwareTr += `<tr class="odd">
                                        <td>${softwareIndex++}</td>
                                        <td>${row.task_name}</td>
                                        <td>
                                            <textarea class="form-control" id="note_${row.task_id}" name="note[]" rows="2" maxlength="100"></textarea>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="frame-wrap">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input check_all_software" name="tasks[]" id="task_${row.task_id}" value="${row.task_id}" onclick="handleCheckboxClick(this)">
                                                        <label class="custom-control-label" for="task_${row.task_id}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;
                                }
                            });
                        } else {
                            hardwareTr = '<tr><td colspan="3" align="center">@lang("lang.no_record_to_display")</td></tr>';
                            softwareTr = '<tr><td colspan="3" align="center">@lang("lang.no_record_to_display")</td></tr>';
                        }
                        // Append the rows to the correct tables
                        $("#tbl_hardware tbody").html(hardwareTr);
                        $("#tbl_software tbody").html(softwareTr);
                    }
                });
            });

            $(document).on('click', '#btn_update', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way
                var id = $("#id").val();
                var category_id = $("#category_id").val();
                var branch_id = $("#branch_id").val();
                var location_id = $("#location_id").val();
                var end_user = $("#end_user").val();
                var asset_id = $("#serial").val();
                var device_name = $("#device_id").val();
                var department_id = $("#department_id").val();
                var maintenance_date = $("#maintenance_date").val();
                var maintenace_by = $("#maintenace_by").val();
                var maintenance_mission_id = $("#maintenance_mission_id").val();
                var reference = $("#reference").val();
                var description = $('#description').summernote('code');

                var maintenaceDetail = [];
                $('#tbl_hardware tbody tr, #tbl_software tbody tr').each(function() {  // Iterate over table rows
                    var note = $(this).find('[name="note[]"]').val();                    
                    var taskId = $(this).find('[name="tasks[]"]:checked').val(); // Get only checked tasks
                    if (taskId) { // Ensure only checked tasks are added
                        maintenaceDetail.push({
                            note: note,
                            task_id: taskId
                        });
                    }
                });
                $(".form-group-select2").each(function(){
                    let formGroup = $(this);
                    let value = formGroup.attr("data-select2-id");
                    let requeredField = formGroup.find(".select2-option").val();
                    let requered = formGroup.find(".required").val();
                    if(!value && requered == ""){ 
                        formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                    }else if(!requeredField && requered == "") {
                        formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                    }else{
                        formGroup.find(".select2-selection--single").css("border-color","#1dc9b7");
                    }
                });
                var num_miss = 0;
                $(".required").each(function(){
                    if($(this).val()==""){ 
                        num_miss++;
                        $(this).addClass("is-invalid");
                        $(this).removeClass("is-valid");
                    }else{
                        $(this).addClass("is-valid");
                        $(this).removeClass("is-invalid");
                    }
                });
                if (num_miss>0) {
                    toastr.error("Please check field all required!");
                    $(".btn-hidden-show").show();
                    $(".btn-loading").css('display', 'none');
                    return false;
                }else{
                    $.ajax({
                        type: "PUT",
                        url: "{{url('admin/maintenance')}}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _token: $('input[name="_token"]').val(),
                            id : id,
                            category_id : category_id,
                            office : branch_id,
                            location : location_id,
                            end_user : end_user,
                            asset_id : asset_id,
                            maintenance_date : maintenance_date,
                            maintenace_by : maintenace_by,
                            description : description,
                            maintenance_mission_id : maintenance_mission_id,
                            reference : reference,
                            device_name : device_name,
                            department_id : department_id,
                            maintenaceDetail : maintenaceDetail,
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Maintenance updated successfully.');
                                window.location.replace("{{ URL('admin/maintenance') }}"); 
                            }
                        }
                    });
                }
            });
        });
        function handleCheckAllHardware(source) {
            checkboxes = $('.check_all_hardware');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        function handleCheckAllSoftware(source) {
            checkboxes = $('.check_all_software');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        function handleCheckboxClick(checkbox) {
            if (checkbox.checked) {
                {checkbox.value}
            } else {
                {checkbox.value}
            }
        }
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
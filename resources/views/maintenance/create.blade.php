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
                        Maintenance
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row mb-2">
                            <div class="col-xl-4">
                                <div class="form-group form-group-select2">
                                    <label class="form-label" for="Serial">Serial <span class="text-danger">*</span></label>
                                    <select class="select2 form-control w-100 select2-hidden-accessible required select2-option" id="serial" name="serial" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($serial as $item)
                                            <option value="{{$item->id}}">{{ $item->serial}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="">Maintenance Date <span class="text-danger">*</span></label>
                                    <input type="date" name="maintenance_date" class="form-control required" id="maintenance_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="maintenace_by">IT Technician <span class="text-danger">*</span></label>
                                    <input type="text" name="maintenace_by" class="form-control required" disabled id="maintenace_by" value="{{Auth::user()->name}}" required>
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
                                <strong>Date Purchase</strong> : <span class="date"></span>,
                                <strong>Lifecycle(Month)</strong> : <span class="lifecycle_month"></span>
                            </p>
                        </div>
                        <br>
                        <div class="row mb-3">
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
                                                                <input type="checkbox" class="custom-control-input" name="" id="defaultInlineHardware" value="" onclick="handleCheckAllHardware(this)">
                                                                <label class="custom-control-label" for="defaultInlineHardware"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                                                                <input type="checkbox" class="custom-control-input" name="" id="defaultInlineSoftware" value="" onclick="handleCheckAllSoftware(this)">
                                                                <label class="custom-control-label" for="defaultInlineSoftware"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label class="form-label" for="Noted">Note:</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-md-right">
                            <div class="btn-hidden-show">
                                <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/maintenance')}}"  type="button">Cancel</a>
                                <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn_create" type="submit">Submit</button>
                            </div>
                            <input type="hidden" value="{{csrf_token()}}" id="token"/>
                            <input type="hidden" name="category_id" id="category_id">
                            <input type="hidden" name="office_id" id="office_id">
                            <input type="hidden" name="location_id" id="location_id">
                            <input type="hidden" name="end_user" id="end_user">
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
                        $("#office_id").val(response.message.office);
                        $("#location_id").val(response.message.location_id);
                        $("#end_user").val(response.message.end_user);
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

                        let hardwareTr = "";
                        let softwareTr = "";
                        if (response.task.length > 0) {
                            let hardwareIndex = 1;
                            let softwareIndex = 1;
                            response.task.forEach((row) => {
                                if (row.type == "Hardware") {
                                    hardwareTr += `<tr class="odd">
                                        <td>${hardwareIndex++}</td>
                                        <td class="sub-message" data-toggle="tooltip" data-html="true" title="${row.description}">${row.task_name}</td>
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
                                        <td class="sub-message" data-toggle="tooltip" data-html="true" title="${row.description}">${row.task_name}</td>
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

            $(document).on('click', '#btn_create', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way
                var category_id = $("#category_id").val();
                var office_id = $("#office_id").val();
                var location_id = $("#location_id").val();
                var end_user = $("#end_user").val();
                var asset_id = $("#serial").val();
                var maintenance_date = $("#maintenance_date").val();
                var maintenace_by = $("#maintenace_by").val();
                // var description = $("#description").val();
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
                var num_miss = 0;
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
                        type: "POST",
                        url: "{{url('admin/maintenance')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _token: $('input[name="_token"]').val(),
                            asset_id : asset_id,
                            category_id : category_id,
                            office : office_id,
                            location : location_id,
                            end_user : end_user,
                            maintenance_date : maintenance_date,
                            maintenace_by : maintenace_by,
                            description : description,
                            maintenaceDetail : maintenaceDetail,
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status == "error") {
                                toastr.error(response.message);
                            }else{
                                toastr.success('Maintenance record created successfully.');
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
        function initializeTooltips() {
            // Destroy any existing tooltips first to prevent conflicts
            $('[data-toggle="tooltip"]').tooltip('dispose');
            
            // Initialize tooltips with proper configuration
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body',
                trigger: 'hover',
                html: true,
                placement: 'top',
                boundary: 'window',
                selector: '[data-toggle="tooltip"]' // Explicit selector
            });
        }
    </script>
@endsection
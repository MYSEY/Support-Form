@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Email</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">Email</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#send_email"><i class="fa fa-plus"></i> New Email</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer btn_trainer"
                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.department')</th>
                                <th>@lang('lang.branch')</th>
                                <th>@lang('lang.subject')</th>
                                <th>@lang('lang.message')</th>
                                <th style="text-align: center;">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="ids">1</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->department ? $item->department->name_english : ""}}</td>
                                        <td>{{$item->branch ? $item->branch->branch_name_en : ""}}</td>
                                        <td>{{$item->subject}}</td>
                                        <td>{{$item->message}}</td>
                                        <td style="text-align: center;">
                                            <a class="btn btn-success update" data-toggle="modal" data-target="#edit_taxes"><i class="fa fa-edit"></i></a>
                                            {{-- <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_taxes"><i class="fa fa-trash-o m-r-5"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="send_email" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Please select Department or Branch</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if (count($department)>0)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Department</label>
                                        <div class="dropdown-menu d-block position-relative float-none">
                                            @foreach ($department as $item)
                                                <a class="dropdown-item" href="{{url('email/create','department'.$item->id)}}">
                                                    <span class="float-right me-3"><i class="fa fa-caret-right" data-bs-toggle="tooltip" aria-label="fa fa-caret-right" data-bs-original-title="fa fa-caret-right"></i></span>{{$item->name_english}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (count($branch)>0)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Branch</label>
                                        <div class="dropdown-menu d-block position-relative float-none">
                                            @foreach ($branch as $item)
                                                <a class="dropdown-item" href="{{url('email/create','branch'.$item->id)}}">
                                                    <span class="float-right me-3"><i class="fa fa-caret-right" data-bs-toggle="tooltip" aria-label="fa fa-caret-right" data-bs-original-title="fa fa-caret-right"></i></span><span>{{ $item->branch_name_en}}</span>
                                                </a>
                                            @endforeach
                                        
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        
    });
</script>
